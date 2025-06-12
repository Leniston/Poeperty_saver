<?php
// property_scraper.php - Multi-site property information extractor

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

function scrapeProperty($url) {
    $domain = parse_url($url, PHP_URL_HOST);
    $domain = str_replace('www.', '', $domain);

    switch (true) {
        case strpos($domain, 'daft.ie') !== false:
            return scrapeDaft($url);
        case strpos($domain, 'myhome.ie') !== false:
            return scrapeMyHome($url);
        case strpos($domain, 'propertypartners.ie') !== false:
            return scrapePropertyPartners($url);
        case strpos($domain, 'sherry.ie') !== false:
            return scrapeSherry($url);
        case strpos($domain, 'remax.ie') !== false:
            return scrapeRemax($url);
        default:
            return scrapeGeneric($url);
    }
}

function scrapeDaft($url) {
    try {
        $html = fetchHTML($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $data = [
            'title' => extractDaftTitle($xpath, $html),
            'price' => extractDaftPrice($xpath, $html),
            'bedrooms' => extractBedrooms($xpath, $html),
            'bathrooms' => extractBathrooms($xpath, $html),
            'property_type' => extractPropertyType($xpath, $html),
            'address' => extractDaftAddress($xpath, $html),
            'image_url' => extractDaftImage($xpath, $html),
            'ber_rating' => extractBER($xpath, $html),
        ];

        return [
            'success' => true,
            'data' => array_filter($data),
            'source' => 'Daft.ie'
        ];

    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage(), 'source' => 'Daft.ie'];
    }
}

function scrapeMyHome($url) {
    try {
        $html = fetchHTML($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $data = [
            'title' => extractMyHomeTitle($xpath, $html),
            'price' => extractMyHomePrice($xpath, $html),
            'bedrooms' => extractBedrooms($xpath, $html),
            'bathrooms' => extractBathrooms($xpath, $html),
            'property_type' => extractPropertyType($xpath, $html),
            'address' => extractMyHomeAddress($xpath, $html),
            'image_url' => extractMyHomeImage($xpath, $html),
            'ber_rating' => extractBER($xpath, $html),
        ];

        return [
            'success' => true,
            'data' => array_filter($data),
            'source' => 'MyHome.ie'
        ];

    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage(), 'source' => 'MyHome.ie'];
    }
}

function scrapePropertyPartners($url) {
    try {
        $html = fetchHTML($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $data = [
            'title' => extractText($xpath, '//h1') ?: extractText($xpath, '//title'),
            'price' => extractGenericPrice($xpath, $html),
            'bedrooms' => extractBedrooms($xpath, $html),
            'bathrooms' => extractBathrooms($xpath, $html),
            'property_type' => extractPropertyType($xpath, $html),
            'image_url' => extractGenericImage($xpath, $html, $url),
            'ber_rating' => extractBER($xpath, $html),
        ];

        return [
            'success' => true,
            'data' => array_filter($data),
            'source' => 'Property Partners'
        ];

    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage(), 'source' => 'Property Partners'];
    }
}

function scrapeSherry($url) {
    try {
        $html = fetchHTML($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $data = [
            'title' => extractText($xpath, '//h1') ?: extractText($xpath, '//title'),
            'price' => extractGenericPrice($xpath, $html),
            'bedrooms' => extractBedrooms($xpath, $html),
            'bathrooms' => extractBathrooms($xpath, $html),
            'property_type' => extractPropertyType($xpath, $html),
            'image_url' => extractGenericImage($xpath, $html, $url),
            'ber_rating' => extractBER($xpath, $html),
        ];

        return [
            'success' => true,
            'data' => array_filter($data),
            'source' => 'Sherry FitzGerald'
        ];

    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage(), 'source' => 'Sherry FitzGerald'];
    }
}

function scrapeRemax($url) {
    try {
        $html = fetchHTML($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $data = [
            'title' => extractText($xpath, '//h1') ?: extractText($xpath, '//title'),
            'price' => extractGenericPrice($xpath, $html),
            'bedrooms' => extractBedrooms($xpath, $html),
            'bathrooms' => extractBathrooms($xpath, $html),
            'property_type' => extractPropertyType($xpath, $html),
            'image_url' => extractGenericImage($xpath, $html, $url),
            'ber_rating' => extractBER($xpath, $html),
        ];

        return [
            'success' => true,
            'data' => array_filter($data),
            'source' => 'Remax'
        ];

    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage(), 'source' => 'Remax'];
    }
}

function scrapeGeneric($url) {
    try {
        $html = fetchHTML($url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $data = [
            'title' => extractGenericTitle($xpath, $html),
            'price' => extractGenericPrice($xpath, $html),
            'bedrooms' => extractBedrooms($xpath, $html),
            'bathrooms' => extractBathrooms($xpath, $html),
            'property_type' => extractPropertyType($xpath, $html),
            'image_url' => extractGenericImage($xpath, $html, $url),
            'ber_rating' => extractBER($xpath, $html),
        ];

        return [
            'success' => true,
            'data' => array_filter($data),
            'source' => 'Generic'
        ];

    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage(), 'source' => 'Generic'];
    }
}

// Site-specific extractors
function extractDaftTitle($xpath, $html) {
    $selectors = [
        '//h1[@data-testid="address"]',
        '//h1[contains(@class, "address")]',
        '//div[@data-testid="address"]',
        '//h1'
    ];
    return findFirstMatch($xpath, $selectors) ?: extractFromTitle($html);
}

function extractDaftPrice($xpath, $html) {
    $selectors = [
        '//span[@data-testid="price"]',
        '//div[@data-testid="price"]',
        '//*[contains(@class, "price")]'
    ];
    return cleanPrice(findFirstMatch($xpath, $selectors));
}

function extractDaftAddress($xpath, $html) {
    $selectors = [
        '//div[@data-testid="address-line"]',
        '//*[contains(@class, "address")]'
    ];
    return findFirstMatch($xpath, $selectors);
}

function extractDaftImage($xpath, $html) {
    $selectors = [
        '//img[contains(@class, "property-image")]/@src',
        '//img[contains(@alt, "property")]/@src',
        '//div[contains(@class, "image")]//img/@src',
        '//picture//img/@src'
    ];

    foreach ($selectors as $selector) {
        $nodes = $xpath->query($selector);
        if ($nodes->length > 0) {
            $src = $nodes->item(0)->nodeValue;
            return makeAbsoluteUrl($src, 'https://www.daft.ie');
        }
    }
    return null;
}

function extractMyHomeTitle($xpath, $html) {
    $selectors = [
        '//h1[@class="property-title"]',
        '//h1[contains(@class, "title")]',
        '//h1'
    ];
    return findFirstMatch($xpath, $selectors) ?: extractFromTitle($html);
}

function extractMyHomePrice($xpath, $html) {
    $selectors = [
        '//div[@class="price"]',
        '//*[contains(@class, "price")]',
        '//span[contains(@class, "price")]'
    ];
    return cleanPrice(findFirstMatch($xpath, $selectors));
}

function extractMyHomeAddress($xpath, $html) {
    $selectors = [
        '//div[contains(@class, "address")]',
        '//p[contains(@class, "address")]'
    ];
    return findFirstMatch($xpath, $selectors);
}

function extractMyHomeImage($xpath, $html) {
    $selectors = [
        '//img[contains(@class, "property")]/@src',
        '//img[contains(@class, "main")]/@src',
        '//div[contains(@class, "image")]//img/@src'
    ];

    foreach ($selectors as $selector) {
        $nodes = $xpath->query($selector);
        if ($nodes->length > 0) {
            $src = $nodes->item(0)->nodeValue;
            return makeAbsoluteUrl($src, 'https://www.myhome.ie');
        }
    }
    return null;
}

// Generic extractors
function extractGenericTitle($xpath, $html) {
    $selectors = [
        '//h1[contains(@class, "property")]',
        '//h1[contains(@class, "title")]',
        '//h1[contains(@class, "address")]',
        '//h1'
    ];
    return findFirstMatch($xpath, $selectors) ?: extractFromTitle($html);
}

function extractGenericPrice($xpath, $html) {
    $selectors = [
        '//*[contains(@class, "price")]',
        '//*[contains(text(), "€")]',
        '//*[contains(text(), "POA")]'
    ];

    foreach ($selectors as $selector) {
        $result = extractText($xpath, $selector);
        if ($result && (strpos($result, '€') !== false || stripos($result, 'POA') !== false)) {
            return cleanPrice($result);
        }
    }

    // Regex fallback
    if (preg_match('/€[\d,]+/i', $html, $matches)) {
        return cleanPrice($matches[0]);
    }

    return null;
}

function extractGenericImage($xpath, $html, $url) {
    $selectors = [
        '//img[contains(@class, "property")]/@src',
        '//img[contains(@class, "main")]/@src',
        '//img[contains(@alt, "property")]/@src',
        '//div[contains(@class, "image")]//img/@src',
        '//picture//img/@src',
        '//img[1]/@src'
    ];

    foreach ($selectors as $selector) {
        $nodes = $xpath->query($selector);
        if ($nodes->length > 0) {
            $src = $nodes->item(0)->nodeValue;
            if ($src && !strpos($src, 'logo') && !strpos($src, 'icon')) {
                return makeAbsoluteUrl($src, $url);
            }
        }
    }
    return null;
}

function extractBedrooms($xpath, $html) {
    $selectors = [
        '//div[contains(@class, "bed")]//span',
        '//*[@data-testid="bed" or @data-testid="beds"]',
        '//*[contains(@class, "bed")]',
        '//*[contains(text(), "bed")]'
    ];

    foreach ($selectors as $selector) {
        $result = extractText($xpath, $selector);
        if ($result && preg_match('/(\d+)/', $result, $matches)) {
            return $matches[1] . ' bed';
        }
    }

    if (preg_match('/(\d+)\s*bed/i', $html, $matches)) {
        return $matches[1] . ' bed';
    }

    return null;
}

function extractBathrooms($xpath, $html) {
    $selectors = [
        '//div[contains(@class, "bath")]//span',
        '//*[@data-testid="bath" or @data-testid="baths"]',
        '//*[contains(@class, "bath")]',
        '//*[contains(text(), "bath")]'
    ];

    foreach ($selectors as $selector) {
        $result = extractText($xpath, $selector);
        if ($result && preg_match('/(\d+)/', $result, $matches)) {
            return $matches[1] . ' bath';
        }
    }

    if (preg_match('/(\d+)\s*bath/i', $html, $matches)) {
        return $matches[1] . ' bath';
    }

    return null;
}

function extractPropertyType($xpath, $html) {
    $selectors = [
        '//div[@data-testid="property-type"]',
        '//*[contains(@class, "property-type")]',
        '//*[contains(@class, "type")]'
    ];

    foreach ($selectors as $selector) {
        $result = extractText($xpath, $selector);
        if ($result) {
            return cleanText($result);
        }
    }

    $types = ['House', 'Apartment', 'Duplex', 'Townhouse', 'Cottage', 'Bungalow', 'Studio'];
    foreach ($types as $type) {
        if (stripos($html, $type) !== false) {
            return $type;
        }
    }

    return null;
}

function extractBER($xpath, $html) {
    $selectors = [
        '//*[contains(@class, "ber")]',
        '//*[contains(text(), "BER")]',
        '//*[@data-testid="ber"]'
    ];

    foreach ($selectors as $selector) {
        $result = extractText($xpath, $selector);
        if ($result && preg_match('/[A-G][0-9]*/', $result, $matches)) {
            return $matches[0];
        }
    }

    if (preg_match('/BER\s*:?\s*([A-G][0-9]*)/i', $html, $matches)) {
        return $matches[1];
    }

    return null;
}

// Helper functions
function fetchHTML($url) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        CURLOPT_HTTPHEADER => [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: gzip, deflate',
            'Connection: keep-alive',
            'Cache-Control: no-cache',
        ],
        CURLOPT_ENCODING => 'gzip',
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("Failed to load page (HTTP $httpCode)");
    }

    if (empty($html)) {
        throw new Exception('No content received');
    }

    return $html;
}

function extractText($xpath, $query) {
    try {
        $nodes = $xpath->query($query);
        if ($nodes && $nodes->length > 0) {
            $text = trim($nodes->item(0)->textContent);
            return !empty($text) ? $text : null;
        }
    } catch (Exception $e) {
        // Ignore XPath errors
    }
    return null;
}

function findFirstMatch($xpath, $selectors) {
    foreach ($selectors as $selector) {
        $result = extractText($xpath, $selector);
        if ($result && strlen($result) > 2) {
            return cleanText($result);
        }
    }
    return null;
}

function extractFromTitle($html) {
    if (preg_match('/<title[^>]*>([^<]+)<\/title>/i', $html, $matches)) {
        $title = strip_tags($matches[1]);
        $excludeWords = ['Daft.ie', 'MyHome.ie', 'Property', 'For Sale'];
        foreach ($excludeWords as $word) {
            if (stripos($title, $word) === false || strlen($title) > 20) {
                return cleanText($title);
            }
        }
    }
    return null;
}

function makeAbsoluteUrl($src, $baseUrl) {
    if (!$src) return null;

    if (filter_var($src, FILTER_VALIDATE_URL)) {
        return $src;
    } elseif (strpos($src, '/') === 0) {
        $parsedBase = parse_url($baseUrl);
        return $parsedBase['scheme'] . '://' . $parsedBase['host'] . $src;
    }
    return null;
}

function cleanText($text) {
    if (!$text) return null;

    $text = trim($text);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

    return $text;
}

function cleanPrice($priceText) {
    if (!$priceText) return null;

    $priceText = trim($priceText);

    if (stripos($priceText, 'POA') !== false || stripos($priceText, 'Price on Application') !== false) {
        return 'POA';
    }

    if (preg_match('/€([\d,]+)/', $priceText, $matches)) {
        $number = str_replace(',', '', $matches[1]);
        if (is_numeric($number)) {
            return '€' . number_format($number);
        }
    }

    return $priceText;
}

// API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $url = $input['url'] ?? '';

    if (empty($url)) {
        echo json_encode(['success' => false, 'error' => 'No URL provided']);
        exit;
    }

    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid URL format']);
        exit;
    }

    $result = scrapeProperty($url);
    echo json_encode($result);
    exit;
}

// Test interface
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['test'])) {
    echo '<h2>Property Scraper Test</h2>';
    echo '<p>Supports: Daft.ie, MyHome.ie, Property Partners, Sherry FitzGerald, Remax, and more</p>';
    echo '<form method="post" style="margin: 20px;">';
    echo '<input type="text" name="test_url" placeholder="Enter property URL" style="width: 500px; padding: 10px;" />';
    echo '<button type="submit">Test Scraper</button>';
    echo '</form>';

    if (isset($_POST['test_url'])) {
        $result = scrapeProperty($_POST['test_url']);
        echo '<pre>' . json_encode($result, JSON_PRETTY_PRINT) . '</pre>';
    }
}
?>