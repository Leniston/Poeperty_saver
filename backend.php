<?php
// backend.php - Complete backend with database setup
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Database configuration
$host = 'localhost';
$dbname = 'property_saver';
$username = 'root';
$password = '';

try {
    // First try to connect without database to create it if needed
    $pdo_temp = new PDO("mysql:host=$host", $username, $password);
    $pdo_temp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist
    $pdo_temp->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo_temp = null;

    // Now connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS properties (
        id INT AUTO_INCREMENT PRIMARY KEY,
        url VARCHAR(500) NOT NULL,
        title VARCHAR(200),
        price VARCHAR(50),
        status ENUM('interested', 'viewing', 'offer', 'rejected') DEFAULT 'interested',
        notes TEXT,
        date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get the endpoint from query parameter
$endpoint = $_GET['endpoint'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

// Route requests
if ($endpoint === 'properties') {
    switch ($method) {
        case 'GET':
            getAllProperties();
            break;
        case 'POST':
            addProperty($input);
            break;
        case 'PUT':
            updateProperty($input);
            break;
        case 'DELETE':
            deleteProperty($input);
            break;
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Endpoint not found']);
}

function getAllProperties() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM properties ORDER BY date_added DESC");
        $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $properties]);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function addProperty($data) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO properties (url, title, price, status, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['url'] ?? '',
            $data['title'] ?? '',
            $data['price'] ?? '',
            $data['status'] ?? 'interested',
            $data['notes'] ?? ''
        ]);

        $id = $pdo->lastInsertId();
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Property added successfully']);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function updateProperty($data) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE properties SET url = ?, title = ?, price = ?, status = ?, notes = ? WHERE id = ?");
        $stmt->execute([
            $data['url'] ?? '',
            $data['title'] ?? '',
            $data['price'] ?? '',
            $data['status'] ?? 'interested',
            $data['notes'] ?? '',
            $data['id'] ?? 0
        ]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Property updated successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Property not found or no changes made']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function deleteProperty($data) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM properties WHERE id = ?");
        $stmt->execute([$data['id'] ?? 0]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Property deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Property not found']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>