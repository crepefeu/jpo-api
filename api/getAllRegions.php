<?php
include_once '../config/Config.php';
header("Strict-Transport-Security: includeSubDomains");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self'");

header("Access-Control-Allow-Origin: " . Config::get('WEBAPP_URL'));
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';

$database = new Database(); // Create a new database object
$db = $database->getConnection(); // Get database connection

$db_table = "regions"; // Set the database table name

// Query to get all regions
$query = "SELECT * FROM " . $db_table;

$stmt = $db->prepare($query);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Go through each row
    extract($row); // Extract row data

    // Store region data in an array
    $region = array(
        "code" => $code,
        "name" => $name
    );
    $regions[] = $region; // Append region data to regions array
}

echo json_encode($regions); // Send regions array as JSON response