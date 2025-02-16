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
include_once 'checkAuthentication.php'; // Check if the user is authenticated

if (!$isAuth) { // Check if the user is authenticated
    $response = array(
        "status" => "error",
        "message" => "Vous n'êtes pas authentifié"
    ); // Create an error response
    echo json_encode($response); // Send the response as JSON
    die(); // Stop executing the script
}

$database = new Database(); // Create a new database object
$db = $database->getConnection(); // Get database connection
$db_table = "diplomaCategories"; // Set the database table name

// Initialize diplomas array to store diploma data
$diplomaCategories = array(
    "names" => [],
    "counts" => [],
);

// Query to get all diploma types and inner join with diplomaCategories and order by diplomaId
$query = "SELECT * FROM " . $db_table . " ORDER BY id ASC";
$stmt = $db->prepare($query);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Go through each row
    extract($row); // Extract row data

    // Query to get the diploma category count accross all attendees
    $query2 = "SELECT COUNT(*) AS diplomaCategoryCount FROM attendees WHERE diplomaCategoryId = " . $id;
    $stmt2 = $db->prepare($query2);
    $stmt2->execute();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($row2);
    
    // Append data to diplomas array
    if ($diplomaCategoryCount == 0) {
        continue; // Skip diplomas with 0 attendees
    } else {
        array_push($diplomaCategories["names"], $categoryName); // Append diploma name to diplomas array
        array_push($diplomaCategories["counts"], $diplomaCategoryCount); // Append diploma count to diplomas array
    }
}
echo json_encode($diplomaCategories); // Send diplomas array as JSON response
?>