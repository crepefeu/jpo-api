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

$db_table = "diplomaTypes"; // Set the database table name

// Query to get all diploma types and inner join with diplomaCategories and order by diplomaId
$query = "SELECT * FROM " . $db_table . " 
INNER JOIN diplomaCategories ON diplomaTypes.categoryId = diplomaCategories.id 
ORDER BY diplomaTypes.id ASC";

$stmt = $db->prepare($query);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Go through each row
    extract($row); // Extract row data

    // Store diploma data in an array
    $diplomaType = array(
        "id" => $id,
        "name" => $diplomaName,
        "category" => $category[] = array( // Store diploma category data in an array
            "id" => $categoryId,
            "name" => $categoryName
        )
    );
    $diplomasTypes[] = $diplomaType; // Append diploma data to diplomas array
}
echo json_encode($diplomasTypes); // Send diplomas array as JSON response
?>

