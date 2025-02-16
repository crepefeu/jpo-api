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
$db_table = "diplomaCategories"; // Set the database table name

// Query to get all diploma categories and order by id
$query = "SELECT * FROM " . $db_table . " ORDER BY id ASC";
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Go through each row
    extract($row); // extract the category data

    // Store diploma category data in an array
    $diplomaCategory = array(
        "id" => $id,
        "name" => $categoryName
    );

    $diplomaCategories[] = $diplomaCategory; // Append diploma category data to diplomaCategories array
}

echo json_encode($diplomaCategories); // Send diplomaCategories array as JSON response
?>