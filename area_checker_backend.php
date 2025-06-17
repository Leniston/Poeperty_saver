<?php
// area_checker_backend.php - Real internet data scraping

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

    // Use multiple data sources for real information
    try {
        // Search education facilities
        $results['education'] = searchEducation($area);
        usleep(500000); // 0.5 second delay

        // Search shopping facilities
        $results['shopping'] = searchShopping($area);
        usleep(500000);

        // Search transport
        $results['transport'] = searchTransport($area);
        usleep(500000);

        // Search healthcare
        $results['healthcare'] = searchHealthcare($area);
        usleep(500000);

        // Search recreation
        $results['recreation'] = searchRecreation($area);
        usleep(500000);

        // Search safety/garda
        $results['safety'] = searchSafety($area);

    } catch (Exception $e) {
        error_log("Error searching for $area: " . $e->getMessage());
    }

    return $results;
}

function searchEducation($area) {
    $results = [];

    // Search Department of Education database and general web
    $queries = [
        "site:education.ie $area schools",
        "$area primary school ireland",
        "$area secondary school ireland",
        "$area national school"
    ];

    foreach ($queries as $query) {
        $searchResults = performWebSearch($query);
        foreach ($searchResults as $result) {
            if (isEducationRelevant($result['title'])) {
                $results[] = [
                    'name' => cleanText($result['title']),
                    'description' => cleanText($result['description']),
                    'type' => identifySchoolType($result['title']),
                    'source' => 'Web Search'
                ];
            }
        }
        if (count($results) >= 5) break;
    }

    return array_slice($results, 0, 6);
}

function searchShopping($area) {
    $results = [];

    // Search for shopping and retail
    $queries = [
        "$area shopping centre ireland",
        "$area supermarket tesco dunnes supervalu",
        "$area shops retail ireland",
        "$area pharmacy chemist"
    ];

    foreach ($queries as $query) {
        $searchResults = performWebSearch($query);
        foreach ($searchResults as $result) {
            if (isShoppingRelevant($result['title'])) {
                $results[] = [
                    'name' => cleanText($result['title']),
                    'description' => cleanText($result['description']),
                    'type' => identifyShopType($result['title']),
                    'source' => 'Web Search'
                ];
            }
        }
        if (count($results) >= 5) break;
    }

    return array_slice($results, 0, 6);
}

function searchTransport($area) {
    $results = [];

    // Search transport information
    $queries = [
        "site:dublinbus.ie $area routes",
        "site:irishrail.ie $area station",
        "$area bus routes ireland transport",
        "$area LUAS DART train"
    ];

    foreach ($queries as $query) {
        $searchResults = performWebSearch($query);
        foreach ($searchResults as $result) {
            if (isTransportRelevant($result['title'])) {
                $results[] = [
                    'name' => cleanText($result['title']),
                    'description' => cleanText($result['description']),
                    'type' => identifyTransportType($result['title']),
                    'source' => 'Web Search'
                ];
            }
        }
        if (count($results) >= 5) break;
    }

    return array_slice($results, 0, 6);
}

function searchHealthcare($area) {
    $results = [];

    // Search healthcare facilities
    $queries = [
        "$area GP doctor medical centre ireland",
        "$area hospital health clinic",
        "$area pharmacy medical",
        "site:hse.ie $area services"
    ];

    foreach ($queries as $query) {
        $searchResults = performWebSearch($query);
        foreach ($searchResults as $result) {
            if (isHealthcareRelevant($result['title'])) {
                $results[] = [
                    'name' => cleanText($result['title']),
                    'description' => cleanText($result['description']),
                    'type' => identifyHealthcareType($result['title']),
                    'source' => 'Web Search'
                ];
            }
        }
        if (count($results) >= 5) break;
    }

    return array_slice($results, 0, 6);
}

function searchRecreation($area) {
    $results = [];

    // Search recreation and entertainment
    $queries = [
        "$area GAA club sports ireland",
        "$area park recreation facilities",
        "$area restaurant pub ireland",
        "$area gym fitness leisure centre"
    ];

    foreach ($queries as $query) {
        $searchResults = performWebSearch($query);
        foreach ($searchResults as $result) {
            if (isRecreationRelevant($result['title'])) {
                $results[] = [
                    'name' => cleanText($result['title']),
                    'description' => cleanText($result['description']),
                    'type' => identifyRecreationType($result['title']),
                    'source' => 'Web Search'
                ];
            }
        }
        if (count($results) >= 5) break;
    }

    return array_slice($results, 0, 6);
}

function searchSafety($area) {
    $results = [];

    // Search safety and garda information
    $queries = [
        "site:garda.ie $area station",
        "$area garda station ireland",
        "$area crime statistics safety",
        "$area community safety ireland"
    ];

    foreach ($queries as $query) {
        $searchResults = performWebSearch($query);
        foreach ($searchResults as $result) {
            if (isSafetyRelevant($result['title'])) {
                $results[] = [
                    'name' => cleanText($result['title']),
                    'description' => cleanText($result['description']),
                    'type' => 'Safety/Security Service',
                    'source' => 'Web Search'
                ];
            }
        }
        if (count($results) >= 5) break;
    }

    return array_slice($results, 0, 6);
}

function performWebSearch($query) {
    // Use SerpApi (free tier) or similar service for reliable results
    // Alternative: Use Bing Web Search API which is more reliable than scraping

    try {
        // Method 1: Try Bing Search API approach
        $results = searchBingAPI($query);
        if (!empty($results)) {
            return $results;
        }

        // Method 2: Fallback to direct web scraping with better user agent rotation
        return scrapeSearchResults($query);

    } catch (Exception $e) {
        error_log("Search error for '$query': " . $e->getMessage());
        return [];
    }
}

function searchBingAPI($query) {
    // This would use Bing Web Search API if you have a key
    // For now, we'll use direct scraping with better methods
    return scrapeSearchResults($query);
}

function scrapeSearchResults($query) {
    $results = [];

    // Try multiple search engines with proper rotation
    $searchEngines = [
        [
            'url' => 'https://www.startpage.com/sp/search?query=' . urlencode($query),
            'parser' => 'parseStartPage'
        ],
        [
            'url' => 'https://duckduckgo.com/html/?q=' . urlencode($query . ' ireland'),
            'parser' => 'parseDuckDuckGo'
        ],
        [
            'url' => 'https://www.bing.com/search?q=' . urlencode($query . ' ireland'),
            'parser' => 'parseBing'
        ]
    ];

    foreach ($searchEngines as $engine) {
        try {
            $html = fetchWebPage($engine['url']);
            if ($html) {
                $parser = $engine['parser'];
                $engineResults = $parser($html);
                $results = array_merge($results, $engineResults);

                if (count($results) >= 5) {
                    break; // Got enough results
                }
            }
        } catch (Exception $e) {
            continue; // Try next engine
        }

        usleep(1000000); // 1 second delay between engines
    }

    return array_slice($results, 0, 8);
}

function fetchWebPage($url) {
    // Rotate user agents to avoid detection
    $userAgents = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/121.0',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:109.0) Gecko/20100101 Firefox/121.0'
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_USERAGENT => $userAgents[array_rand($userAgents)],
        CURLOPT_HTTPHEADER => [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: en-IE,en-US;q=0.8,en;q=0.6',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: none',
            'Cache-Control: max-age=0'
        ],
        CURLOPT_ENCODING => 'gzip',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_COOKIEJAR => tempnam(sys_get_temp_dir(), 'cookie'),
        CURLOPT_COOKIEFILE => tempnam(sys_get_temp_dir(), 'cookie'),
    ]);

    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && !empty($html)) {
        return $html;
    }

    return false;
}

function parseStartPage($html) {
    $results = [];

    // StartPage has clean, parseable results
    if (preg_match_all('/<h3[^>]*><a[^>]*>([^<]+)<\/a><\/h3>.*?<p[^>]*>([^<]+)<\/p>/is', $html, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $results[] = [
                'title' => html_entity_decode(strip_tags($match[1]), ENT_QUOTES, 'UTF-8'),
                'description' => html_entity_decode(strip_tags($match[2]), ENT_QUOTES, 'UTF-8')
            ];
        }
    }

    return $results;
}

function parseDuckDuckGo($html) {
    $results = [];

    // DuckDuckGo parsing
    if (preg_match_all('/<a[^>]*class="[^"]*result__a[^"]*"[^>]*>([^<]+)<\/a>/i', $html, $matches)) {
        foreach ($matches[1] as $title) {
            $results[] = [
                'title' => html_entity_decode(strip_tags($title), ENT_QUOTES, 'UTF-8'),
                'description' => ''
            ];
        }
    }

    return $results;
}

function parseBing($html) {
    $results = [];

    // Bing parsing
    if (preg_match_all('/<h2><a[^>]*>([^<]+)<\/a><\/h2>/i', $html, $matches)) {
        foreach ($matches[1] as $title) {
            $results[] = [
                'title' => html_entity_decode(strip_tags($title), ENT_QUOTES, 'UTF-8'),
                'description' => ''
            ];
        }
    }

    return $results;
}

// Relevance checking functions
function isEducationRelevant($text) {
    return preg_match('/school|college|university|education|academy|institute/i', $text) &&
        !preg_match('/facebook|twitter|linkedin|jobs|property/i', $text);
}

function isShoppingRelevant($text) {
    return preg_match('/shop|store|market|centre|center|tesco|dunnes|supervalu|lidl|aldi|spar|centra|pharmacy/i', $text) &&
        !preg_match('/facebook|twitter|linkedin|jobs|property/i', $text);
}

function isTransportRelevant($text) {
    return preg_match('/bus|train|dart|luas|transport|station|route|dublin bus|iarnrod|irish rail/i', $text) &&
        !preg_match('/facebook|twitter|linkedin|jobs|property/i', $text);
}

function isHealthcareRelevant($text) {
    return preg_match('/doctor|medical|hospital|pharmacy|gp|health|clinic|hse/i', $text) &&
        !preg_match('/facebook|twitter|linkedin|jobs|property/i', $text);
}

function isRecreationRelevant($text) {
    return preg_match('/park|club|gym|restaurant|pub|sport|leisure|recreation|gaa|football/i', $text) &&
        !preg_match('/facebook|twitter|linkedin|jobs|property/i', $text);
}

function isSafetyRelevant($text) {
    return preg_match('/garda|police|safety|crime|security|station/i', $text) &&
        !preg_match('/facebook|twitter|linkedin|jobs|property/i', $text);
}

// Type identification functions
function identifySchoolType($text) {
    if (preg_match('/primary|national school|ns\b/i', $text)) return 'Primary School';
    if (preg_match('/secondary|post.?primary|community school|cs\b/i', $text)) return 'Secondary School';
    if (preg_match('/college|university|institute/i', $text)) return 'Third Level';
    return 'Educational Institution';
}

function identifyShopType($text) {
    if (preg_match('/tesco|dunnes|supervalu|lidl|aldi|spar|centra/i', $text)) return 'Supermarket';
    if (preg_match('/shopping centre|shopping center|mall/i', $text)) return 'Shopping Centre';
    if (preg_match('/pharmacy|chemist/i', $text)) return 'Pharmacy';
    return 'Retail Store';
}

function identifyTransportType($text) {
    if (preg_match('/dart|train|railway|iarnrod/i', $text)) return 'Rail Transport';
    if (preg_match('/bus|dublin bus/i', $text)) return 'Bus Service';
    if (preg_match('/luas|tram/i', $text)) return 'Luas/Tram';
    return 'Transport Service';
}

function identifyHealthcareType($text) {
    if (preg_match('/hospital/i', $text)) return 'Hospital';
    if (preg_match('/gp|doctor|medical centre/i', $text)) return 'GP/Medical Centre';
    if (preg_match('/pharmacy|chemist/i', $text)) return 'Pharmacy';
    return 'Healthcare Facility';
}

function identifyRecreationType($text) {
    if (preg_match('/park|green/i', $text)) return 'Park/Green Space';
    if (preg_match('/gym|fitness|leisure/i', $text)) return 'Fitness/Leisure';
    if (preg_match('/gaa|football|rugby|sports|club/i', $text)) return 'Sports Club';
    if (preg_match('/restaurant|cafe|pub|bar/i', $text)) return 'Food & Drink';
    return 'Recreation Facility';
}

function cleanText($text) {
    if (empty($text)) return '';

    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);

    // Remove common unwanted suffixes
    $text = preg_replace('/\s*-\s*(Google|Bing|Facebook|Twitter|Wikipedia).*$/i', '', $text);
    $text = preg_replace('/\s*\|\s*.*$/i', '', $text);

    return $text;
}

// Main API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['area'])) {
            throw new Exception('Area name is required');
        }

        $area = trim($input['area']);

        if (empty($area)) {
            throw new Exception('Area name cannot be empty');
        }

        // Perform real internet searches
        $results = searchAreaInformation($area);

        // Count total results
        $totalResults = 0;
        foreach ($results as $category => $items) {
            $totalResults += count($items);
        }

        echo json_encode([
            'success' => true,
            'data' => $results,
            'area' => $area,
            'timestamp' => date('Y-m-d H:i:s'),
            'sources' => 'Real Internet Search (StartPage, DuckDuckGo, Bing)',
            'total_results' => $totalResults,
            'note' => 'Live internet data - not pre-programmed'
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'area' => isset($input['area']) ? $input['area'] : 'Unknown'
        ]);
    }
} else {
    echo json_encode([
        'service' => 'Irish Area Information Checker (Real Internet Data)',
        'description' => 'Scrapes real information from multiple search engines',
        'data_sources' => [
            'StartPage.com (primary)',
            'DuckDuckGo.com',
            'Bing.com',
            'Government sites (education.ie, hse.ie, garda.ie)',
            'Transport sites (dublinbus.ie, irishrail.ie)'
        ],
        'features' => [
            'Real-time web scraping',
            'Multiple search engine fallback',
            'Government database searches',
            'Smart relevance filtering',
            'User agent rotation'
        ],
        'note' => 'Pulls actual current data from the internet'
    ]);
}
?>