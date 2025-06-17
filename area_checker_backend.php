<?php
// area_checker_backend.php - Comprehensive area information scraper

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

function searchAreaInformation($area) {
    $results = [
        'education' => [],
        'shopping' => [],
        'transport' => [],
        'healthcare' => [],
        'recreation' => [],
        'safety' => []
    ];

    // Search queries for different categories
    $searchQueries = [
        'education' => [
            "$area primary schools",
            "$area secondary schools",
            "$area colleges",
            "$area schools near me"
        ],
        'shopping' => [
            "$area supermarkets",
            "$area grocery stores",
            "$area shopping center",
            "$area Tesco Dunnes SuperValu"
        ],
        'transport' => [
            "$area bus routes",
            "$area Dublin Bus",
            "$area train station",
            "$area DART LUAS"
        ],
        'healthcare' => [
            "$area GP doctors",
            "$area medical center",
            "$area pharmacy",
            "$area hospital near"
        ],
        'recreation' => [
            "$area parks",
            "$area gym fitness",
            "$area sports clubs",
            "$area restaurants pubs"
        ],
        'safety' => [
            "$area crime statistics",
            "$area Garda station",
            "$area safety",
            "$area crime rate Ireland"
        ]
    ];

    foreach ($searchQueries as $category => $queries) {
        try {
            $categoryResults = [];

            foreach ($queries as $query) {
                $searchResults = performGoogleSearch($query);
                if (!empty($searchResults)) {
                    $categoryResults = array_merge($categoryResults, $searchResults);
                }

                // Small delay to be respectful
                usleep(500000); // 0.5 seconds
            }

            // Process and clean results for this category
            $results[$category] = processResults($categoryResults, $category, $area);

        } catch (Exception $e) {
            error_log("Error searching $category for $area: " . $e->getMessage());
        }
    }

    return $results;
}

function performGoogleSearch($query) {
    try {
        $encodedQuery = urlencode($query . " Ireland");
        $url = "https://www.google.com/search?q=" . $encodedQuery . "&num=10";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language: en-IE,en;q=0.9',
                'Accept-Encoding: gzip, deflate',
                'Connection: keep-alive',
            ],
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || empty($html)) {
            throw new Exception("Failed to get search results (HTTP $httpCode)");
        }

        return parseGoogleResults($html);

    } catch (Exception $e) {
        error_log("Google search error for '$query': " . $e->getMessage());
        return [];
    }
}

function parseGoogleResults($html) {
    $results = [];

    // Create DOMDocument
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);

    // Try multiple selectors for Google search results
    $selectors = [
        '//div[@class="g"]',
        '//div[contains(@class, "g ")]',
        '//div[@data-ved]',
        '//div[contains(@class, "Gx5Zad")]'
    ];

    foreach ($selectors as $selector) {
        $nodes = $xpath->query($selector);

        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                $result = extractResultInfo($xpath, $node);
                if ($result) {
                    $results[] = $result;
                }
            }
            break; // Use first working selector
        }
    }

    // If main results failed, try alternative parsing
    if (empty($results)) {
        $results = parseAlternativeResults($html);
    }

    return array_slice($results, 0, 8); // Limit to 8 results per query
}

function extractResultInfo($xpath, $node) {
    try {
        // Try different selectors for title
        $titleSelectors = [
            './/h3',
            './/a/h3',
            './/div[@role="heading"]',
            './/span[contains(@class, "LC20lb")]'
        ];

        $title = '';
        foreach ($titleSelectors as $selector) {
            $titleNodes = $xpath->query($selector, $node);
            if ($titleNodes->length > 0) {
                $title = trim($titleNodes->item(0)->textContent);
                break;
            }
        }

        if (empty($title)) return null;

        // Try different selectors for description/snippet
        $descSelectors = [
            './/span[contains(@class, "st")]',
            './/div[contains(@class, "VwiC3b")]',
            './/div[contains(@class, "IsZvec")]',
            './/span[contains(@class, "aCOpRe")]'
        ];

        $description = '';
        foreach ($descSelectors as $selector) {
            $descNodes = $xpath->query($selector, $node);
            if ($descNodes->length > 0) {
                $description = trim($descNodes->item(0)->textContent);
                break;
            }
        }

        return [
            'name' => $title,
            'description' => $description,
            'source' => 'Google Search'
        ];

    } catch (Exception $e) {
        return null;
    }
}

function parseAlternativeResults($html) {
    $results = [];

    // Use regex as fallback to extract basic information
    $patterns = [
        '/<h3[^>]*>([^<]+)<\/h3>/i',
        '/<span[^>]*class="[^"]*LC20lb[^"]*"[^>]*>([^<]+)<\/span>/i',
        '/<div[^>]*role="heading"[^>]*>([^<]+)<\/div>/i'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match_all($pattern, $html, $matches)) {
            foreach ($matches[1] as $match) {
                $title = html_entity_decode(strip_tags($match), ENT_QUOTES, 'UTF-8');
                if (strlen($title) > 10 && strlen($title) < 200) {
                    $results[] = [
                        'name' => $title,
                        'description' => '',
                        'source' => 'Google Search (Fallback)'
                    ];
                }
            }
            if (!empty($results)) break;
        }
    }

    return array_slice($results, 0, 5);
}

function processResults($results, $category, $area) {
    if (empty($results)) return [];

    $processed = [];
    $seen = [];

    foreach ($results as $result) {
        // Clean and validate the result
        $name = cleanText($result['name']);
        $description = cleanText($result['description']);

        // Skip if empty or duplicate
        if (empty($name) || in_array(strtolower($name), $seen)) {
            continue;
        }

        // Category-specific processing
        $processedResult = processCategorySpecific($result, $category, $area);

        if ($processedResult) {
            $processed[] = $processedResult;
            $seen[] = strtolower($name);
        }

        // Limit results per category
        if (count($processed) >= 8) break;
    }

    return $processed;
}

function processCategorySpecific($result, $category, $area) {
    $name = $result['name'];
    $description = $result['description'];

    // Skip irrelevant results
    if (shouldSkipResult($name, $description, $category)) {
        return null;
    }

    $processed = [
        'name' => $name,
        'description' => $description
    ];

    // Extract additional info based on category
    switch ($category) {
        case 'education':
            $processed['type'] = identifySchoolType($name, $description);
            break;

        case 'shopping':
            $processed['type'] = identifyShopType($name, $description);
            break;

        case 'healthcare':
            $processed['type'] = identifyHealthcareType($name, $description);
            break;

        case 'transport':
            $processed['type'] = identifyTransportType($name, $description);
            break;

        case 'recreation':
            $processed['type'] = identifyRecreationType($name, $description);
            break;

        case 'safety':
            $processed = processSafetyInfo($processed, $name, $description);
            break;
    }

    // Extract rating if present
    if (preg_match('/(\d+\.?\d*)\s*(?:\/5|stars?|rating)/i', $description, $matches)) {
        $processed['rating'] = $matches[1] . '★';
    }

    // Extract address if present
    if (preg_match('/([A-Z][^,]+,\s*[^,]+,\s*(?:Co\.\s*)?[A-Z][^,]+)/i', $description, $matches)) {
        $processed['address'] = trim($matches[1]);
    }

    return $processed;
}

function shouldSkipResult($name, $description, $category) {
    $skipTerms = [
        'wikipedia', 'facebook', 'twitter', 'instagram', 'linkedin',
        'youtube', 'tiktok', 'snapchat', 'indeed', 'jobs.ie',
        'property', 'for sale', 'rent', 'daft.ie', 'myhome.ie'
    ];

    $text = strtolower($name . ' ' . $description);

    foreach ($skipTerms as $term) {
        if (strpos($text, $term) !== false) {
            return true;
        }
    }

    // Category-specific skips
    switch ($category) {
        case 'education':
            if (!preg_match('/school|college|university|education|academy|institute/i', $text)) {
                return true;
            }
            break;

        case 'shopping':
            if (!preg_match('/shop|store|market|tesco|dunnes|supervalu|lidl|aldi|spar/i', $text)) {
                return true;
            }
            break;
    }

    return false;
}

function identifySchoolType($name, $description) {
    $text = strtolower($name . ' ' . $description);

    if (preg_match('/primary|national school|ns\b/i', $text)) return 'Primary School';
    if (preg_match('/secondary|post.?primary|community school|cs\b/i', $text)) return 'Secondary School';
    if (preg_match('/college|university|institute of technology|it\b/i', $text)) return 'Third Level';
    if (preg_match('/creche|montessori|preschool|daycare/i', $text)) return 'Early Childhood';

    return 'Educational Institution';
}

function identifyShopType($name, $description) {
    $text = strtolower($name . ' ' . $description);

    if (preg_match('/tesco|dunnes|supervalu|lidl|aldi|spar|centra|londis/i', $text)) return 'Supermarket';
    if (preg_match('/shopping centre|shopping center|mall/i', $text)) return 'Shopping Centre';
    if (preg_match('/pharmacy|chemist/i', $text)) return 'Pharmacy';
    if (preg_match('/hardware|diy/i', $text)) return 'Hardware Store';

    return 'Retail Store';
}

function identifyHealthcareType($name, $description) {
    $text = strtolower($name . ' ' . $description);

    if (preg_match('/hospital/i', $text)) return 'Hospital';
    if (preg_match('/gp|doctor|medical centre|medical center/i', $text)) return 'GP/Medical Centre';
    if (preg_match('/pharmacy|chemist/i', $text)) return 'Pharmacy';
    if (preg_match('/dental|dentist/i', $text)) return 'Dental Practice';
    if (preg_match('/physio|therapy/i', $text)) return 'Therapy Services';

    return 'Healthcare Facility';
}

function identifyTransportType($name, $description) {
    $text = strtolower($name . ' ' . $description);

    if (preg_match('/dart|train|railway|rail/i', $text)) return 'Rail Transport';
    if (preg_match('/bus|dublin bus/i', $text)) return 'Bus Service';
    if (preg_match('/luas|tram/i', $text)) return 'Luas/Tram';
    if (preg_match('/taxi/i', $text)) return 'Taxi Service';
    if (preg_match('/airport/i', $text)) return 'Airport';

    return 'Transport Service';
}

function identifyRecreationType($name, $description) {
    $text = strtolower($name . ' ' . $description);

    if (preg_match('/park|green|recreation/i', $text)) return 'Park/Green Space';
    if (preg_match('/gym|fitness|leisure centre/i', $text)) return 'Fitness/Leisure';
    if (preg_match('/gaa|football|soccer|rugby|sports/i', $text)) return 'Sports Club';
    if (preg_match('/restaurant|cafe|pub|bar/i', $text)) return 'Food & Drink';
    if (preg_match('/cinema|theatre|arts/i', $text)) return 'Entertainment';

    return 'Recreation