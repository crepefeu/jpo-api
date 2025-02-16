<?php
include_once '../config/Config.php';
header("Strict-Transport-Security: includeSubDomains");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self'");

header("Access-Control-Allow-Origin: " . Config::get('WEBAPP_URL'));
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../middleware/JWTMiddleware.php';
include_once '../class/JWTHandler.php';

JWTMiddleware::validateToken();
$jwtHandler = new JWTHandler();

$database = new Database(); // Create a new database object
$db = $database->getConnection(); // Get database connection

$showPercentagesOnCharts = $_POST['showPercentagesOnCharts'] == "true" ? 1 : 0; // Get the showPercentagesOnCharts value from the POST request
$showLegendOnCharts = $_POST['showLegendOnCharts'] == "true" ? 1 : 0; // Get the showLegendOnCharts value from the POST request
$defaultTheme = $_POST['defaultTheme']; // Get the defaultTheme value from the POST request

// Retrieve the token from the header
$headers = getallheaders();
        
if (isset($headers['Authorization'])) {
    $auth_header = $headers['Authorization'];
    if (preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) {
        $jwt = $matches[1];
    }
}

// Retrieve the user id
$data = $jwtHandler->validateToken($jwt); // Get the user id from the JWT token
$userId = $data['user_id']; // Get the user id from the JWT token

// Query to update user preferences
$query = "UPDATE userPreferences SET 
        defaultTheme = :defaultTheme,
        showPercentagesOnCharts = :showPercentagesOnCharts,
        showLegendOnCharts = :showLegendOnCharts
        WHERE adminId = :adminId";

$stmt = $db->prepare($query);

// Bind the values to the query
$stmt->bindParam(':showPercentagesOnCharts', $showPercentagesOnCharts);
$stmt->bindParam(':showLegendOnCharts', $showLegendOnCharts);
$stmt->bindParam(':defaultTheme', $defaultTheme);
$stmt->bindParam(':adminId', $userId, PDO::PARAM_STR);
$stmt->execute();

// Return the user preferences
$query = "SELECT * FROM userPreferences WHERE adminId = :adminId"; // Query to get the user preferences
$stmt = $db->prepare($query);
$stmt->bindParam(':adminId', $userId, PDO::PARAM_STR); // Bind the user id to the query
$stmt->execute();
$row["userPreferences"] = $stmt->fetch(PDO::FETCH_ASSOC); // Get the user preferences

// Go through each user preference except the first one and set the value to true if it is 1 and false if it is 0
foreach ($row["userPreferences"] as $key => $value) {
    if ($key != "adminId") { // Check if the key is not id or adminId
        if ($key == 'defaultTheme') { // Check if the key is defaultTheme
            $row["userPreferences"][$key] = $value; // Set the value to the value in the database
        } else {
            if ($value == 1) {
                $row["userPreferences"][$key] = true; // Set the value to true
            } else {
                $row["userPreferences"][$key] = false; // Set the value to false
            }
        }
    }
}

// Set response as an array with user preferences
$response = array(
    'status' => 'success',
    'message' => 'Préférences enregistrées',
    'userPreferences' => $row["userPreferences"]
);

echo json_encode($response); // Send response as JSON
