<?php
// Database configuration
$db_host = 'localhost';
$db_name = 'Hospital';
$db_user = 'root';
$db_pass = '';

// Server config to avoid CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define API routes
$request_uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $request_uri);

// Check for the base path, e.g., /api
if ($parts[2] !== "api") {
    http_response_code(404);
    echo json_encode(array("message" => "Not Found","request"=>$request_uri,"parts" => print_r($parts)));
    exit();
}

// Determine the table based on the URI
$table = $parts[3];

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($table) {
    case 'patients':
        include('patients.php');
        break;
    case 'nurses':
        include('nurses.php');
        break;
    case 'calls':
        include('calls.php');
        break;
    case 'areas':
        include('areas.php');
        break;
    case 'users':
        include('users.php');
        break;
    default:
        http_response_code(404);
        echo json_encode(array("message" => "Table not found"));
        break;
}

// Close the database connection
$conn->close();
?>
