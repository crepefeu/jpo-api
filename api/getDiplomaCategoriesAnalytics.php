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
include_once '../middleware/JWTMiddleware.php';

JWTMiddleware::validateToken();

$database = new Database(); // Create a new database object
$db = $database->getConnection(); // Get database connection
$db_table = "diplomaCategories"; // Set the database table name

// Initialize diplomas array to store diploma data
$diplomaCategories = array(
    "names" => [],
    "counts" => [],
);

// // Query to get all diploma types and inner join with diplomaCategories and order by diplomaId
$query = "SELECT * FROM " . $db_table . " ORDER BY categoryName ASC";
$stmt = $db->prepare($query);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Go through each row
    // Get the id and name of the diploma category
    $id = $row['id'];
    $categoryName = $row['categoryName'];
    // Query to get the diploma category count accross all attendees
    $query2 = "SELECT COUNT(*) AS diplomaCategoryCount FROM attendees WHERE diplomaCategoryId = :categoryId";
    $stmt2 = $db->prepare($query2);
    $stmt2->bindParam(':categoryId', $id, PDO::PARAM_STR);
    $stmt2->execute();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    $diplomaCategoryCount = $row2['diplomaCategoryCount']; // Get the diploma category count

    // Append data to diplomas array
    if ($diplomaCategoryCount == 0) {
        continue; // Skip diplomas with 0 attendees
    } else {
        array_push($diplomaCategories["names"], $categoryName); // Append diploma name to diplomas array
        array_push($diplomaCategories["counts"], $diplomaCategoryCount); // Append diploma count to diplomas array
    }
}

echo json_encode($diplomaCategories); // Send diplomas array as JSON response