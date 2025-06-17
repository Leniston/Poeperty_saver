<?php
// Turn off error display and force JSON responses
ini_set('display_errors', 0);
error_reporting(0);

// Force JSON content type early
header('Content-Type: application/json');

// Catch any fatal errors and return JSON
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && $error['type'] === E_ERROR) {
        echo json_encode([
            'success' => false,
            'error' => 'Server error: ' . $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line']
        ]);
    }
});
// location_analyzer_backend.php - Complete backend with your exact coordinates

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

function calculateAllDistances($propertyAddress, $locations) {
    $results = [];

    // First, geocode the property address
    $propertyCoords = geocodeAddress($propertyAddress);

    if (!$propertyCoords) {
        throw new Exception("Could not find coordinates for property address: " . $propertyAddress);
    }

    // Hardcoded coordinates for your 5 locations (exact coordinates you provided!)
    $locationCoords = [
        'Beaumont Hospital, Dublin' => ['lat' => 53.392036889344304, 'lng' => -6.222410235610356],
        'Kildare County Council, Naas' => ['lat' => 53.214458618922286, 'lng' => -6.671644364235291],
        'Wood Avens, Clondalkin' => ['lat' => 53.33816188132709, 'lng' => -6.403522158133173],
        'Allen View Heights, Newbridge' => ['lat' => 53.17731427590012, 'lng' => -6.819588366248126],
        'Royal Oak, Enfield' => ['lat' => 53.41154742467154, 'lng' => -6.818400744034172]
    ];

    // Transport modes you want: driving, motorcycle, public transport
    $transportModes = ['driving', 'motorcycle', 'transit'];

    foreach ($locations as $location) {
        try {
            // Use hardcoded coordinates if available, otherwise try geocoding
            $destinationCoords = null;

            foreach ($locationCoords as $knownLocation => $coords) {
                if (stripos($location, explode(',', $knownLocation)[0]) !== false) {
                    $destinationCoords = $coords;
                    $destinationCoords['display_name'] = $knownLocation;
                    break;
                }
            }

            // Fallback to geocoding if not in our hardcoded list
            if (!$destinationCoords) {
                $destinationCoords = geocodeAddress($location);
            }

            if (!$destinationCoords) {
                error_log("Could not find coordinates for: " . $location);
                continue;
            }

            // Calculate for all 3 transport modes
            foreach ($transportModes as $mode) {
                $distance_result = calculateDistance(
                    $propertyCoords,
                    $destinationCoords,
                    $location,
                    $mode
                );

                if ($distance_result) {
                    $distance_result['property_coords'] = $propertyCoords;
                    $results[] = $distance_result;
                }
            }
        } catch (Exception $e) {
            error_log("Distance calculation error for {$location}: " . $e->getMessage());
            // Continue with other locations
        }
    }

    return $results;
}

function geocodeAddress($address) {
    // Clean up the address for better geocoding
    $address = trim($address);

    // Add Ireland if not already present
    if (stripos($address, 'ireland') === false && stripos($address, 'dublin') === false) {
        $address .= ', Ireland';
    }

    // URL encode for the API
    $encodedAddress = urlencode($address);

    // Try multiple geocoding approaches
    $urls = [
        // Primary: Nominatim with Ireland focus
        "https://nominatim.openstreetmap.org/search?format=json&q={$encodedAddress}&limit=1&countrycodes=ie&addressdetails=1",
        // Backup: Broader search
        "https://nominatim.openstreetmap.org/search?format=json&q={$encodedAddress}&limit=1&addressdetails=1"
    ];

    foreach ($urls as $url) {
        try {
            // Set a user agent (required by Nominatim)
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: PropertyLocationAnalyzer/1.0\r\n",
                    'timeout' => 15
                ]
            ]);

            $response = file_get_contents($url, false, $context);

            if ($response === FALSE) {
                continue; // Try next URL
            }

            $data = json_decode($response, true);

            if (!empty($data)) {
                $result = $data[0];

                return [
                    'lat' => (float) $result['lat'],
                    'lng' => (float) $result['lon'],
                    'display_name' => $result['display_name']
                ];
            }
        } catch (Exception $e) {
            error_log("Geocoding attempt failed: " . $e->getMessage());
            continue;
        }

        // Be respectful to the free service
        usleep(250000); // 0.25 second delay between attempts
    }

    return null;
}

function calculateDistance($origin, $destination, $destinationName, $travelMode) {
    // Calculate straight-line distance using Haversine formula
    $distance_km = haversineDistance(
        $origin['lat'], $origin['lng'],
        $destination['lat'], $destination['lng']
    );

    // Estimate travel time based on mode and apply route factor
    $travel_time_minutes = estimateTravelTime($distance_km, $travelMode);

    // Apply route factor (roads aren't straight lines)
    $route_factor = getRouteFactor($travelMode);
    $route_distance_km = $distance_km * $route_factor;

    return [
        'destination' => $destinationName,
        'travel_mode' => $travelMode,
        'distance' => number_format($route_distance_km, 1) . ' km',
        'distance_value' => $route_distance_km * 1000, // in meters
        'duration' => formatDuration($travel_time_minutes),
        'duration_value' => $travel_time_minutes * 60, // in seconds
    ];
}

function haversineDistance($lat1, $lng1, $lat2, $lng2) {
    $earth_radius = 6371; // Earth's radius in kilometers

    $lat1_rad = deg2rad($lat1);
    $lng1_rad = deg2rad($lng1);
    $lat2_rad = deg2rad($lat2);
    $lng2_rad = deg2rad($lng2);

    $delta_lat = $lat2_rad - $lat1_rad;
    $delta_lng = $lng2_rad - $lng1_rad;

    $a = sin($delta_lat / 2) * sin($delta_lat / 2) +
        cos($lat1_rad) * cos($lat2_rad) *
        sin($delta_lng / 2) * sin($delta_lng / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earth_radius * $c;
}

function estimateTravelTime($distance_km, $travelMode) {
    // Average speeds in km/h for different modes in Ireland
    $speeds = [
        'driving' => 40,      // Car driving with traffic
        'motorcycle' => 50,   // Motorcycle can navigate traffic better
        'transit' => 25,      // Public transport including stops and connections
    ];

    $speed = $speeds[$travelMode] ?? $speeds['driving'];

    // Convert to minutes
    $time_hours = $distance_km / $speed;
    $time_minutes = $time_hours * 60;

    // Add buffer time for public transport (waiting, transfers)
    if ($travelMode === 'transit') {
        $time_minutes += 15; // Average wait/transfer time
    }

    // Minimum time constraints
    $min_times = [
        'driving' => 5,       // Minimum 5 minutes for driving
        'motorcycle' => 4,    // Motorcycles slightly faster
        'transit' => 20,      // Minimum 20 minutes for public transport
    ];

    return max($time_minutes, $min_times[$travelMode] ?? 5);
}

function getRouteFactor($travelMode) {
    // Factor to account for roads not being straight lines
    $factors = [
        'driving' => 1.3,      // Roads follow streets
        'motorcycle' => 1.25,  // Motorcycles can take slightly more direct routes
        'transit' => 1.4,      // Public transport routes are less direct
    ];

    return $factors[$travelMode] ?? 1.3;
}

function formatDuration($minutes) {
    if ($minutes < 60) {
        return round($minutes) . ' min';
    } else {
        $hours = floor($minutes / 60);
        $mins = round($minutes % 60);
        return "{$hours}h {$mins}m";
    }
}

// Main API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['property_address']) || !isset($input['locations'])) {
            throw new Exception('Missing required parameters');
        }

        $propertyAddress = trim($input['property_address']);
        $locations = $input['locations'];

        if (empty($propertyAddress)) {
            throw new Exception('Property address is required');
        }

        if (empty($locations) || !is_array($locations)) {
            throw new Exception('At least one location is required');
        }

        // Rate limiting - be respectful to free services
        usleep(500000); // 0.5 second delay

        // Calculate distances using free services
        $results = calculateAllDistances($propertyAddress, $locations);

        if (empty($results)) {
            throw new Exception('Could not calculate any distances. Please check the addresses are in Ireland.');
        }

        echo json_encode([
            'success' => true,
            'data' => $results,
            'total_calculations' => count($results),
            'transport_modes' => ['driving', 'motorcycle', 'transit'],
            'service' => 'OpenStreetMap (Free)',
            'note' => 'Travel times calculated automatically for all transport modes'
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'service' => 'Free OpenStreetMap Service'
        ]);
    }
} else {
    // API documentation
    echo json_encode([
        'service' => 'Simple Location Analyzer',
        'description' => 'Auto-calculates travel times to your key locations',
        'transport_modes' => ['driving', 'motorcycle', 'public_transport'],
        'locations_analyzed' => [
            'Beaumont Hospital',
            'Kildare County Council, Naas',
            'Wood Avens, Clondalkin',
            'Allen View Heights, Newbridge',
            'Royal Oak, Enfield'
        ],
        'usage' => 'Just provide property address and get automatic analysis',
        'cost' => 'Free forever'
    ]);
}
?>