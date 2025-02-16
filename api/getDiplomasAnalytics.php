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

$database = new Database();
$db = $database->getConnection();

$db_table = "diplomaTypes";

// Initialize diplomas array to store diploma data
$diplomas = array(
    "names" => [],
    "counts" => [],
);

// Query to get all diploma types and inner join with diplomaCategories and order
$query = "SELECT 
    diplomaTypes.id as diplomaId, 
    diplomaTypes.diplomaName, 
    diplomaCategories.id as categoryId,
    diplomaCategories.categoryName 
FROM " . $db_table . " 
INNER JOIN diplomaCategories ON diplomaTypes.categoryId = diplomaCategories.id 
ORDER BY diplomaTypes.diplomaName ASC";

$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $diplomaId = preg_replace('/\s+/', '', $row['diplomaId']);
    $diplomaName = $row['diplomaName'];

    // Query to get the diploma count across all attendees
    $query2 = "SELECT COUNT(*) AS diplomaCount FROM attendees WHERE diplomaId = :id";
    $stmt2 = $db->prepare($query2);
    $stmt2->bindParam(':id', $diplomaId, PDO::PARAM_STR);
    $stmt2->execute();
    
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $diplomaCount = (int)$row2['diplomaCount'];
    
    if ($diplomaCount > 0) {
        array_push($diplomas["names"], $diplomaName);
        array_push($diplomas["counts"], $diplomaCount);
    }
}
echo json_encode($diplomas); // Send diplomas array as JSON response
?>

