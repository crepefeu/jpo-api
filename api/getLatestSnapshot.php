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

$db_table = "analyticsSnapshots"; // Set the database table name

// Query to get latest snapshot
$query = "SELECT * FROM " . $db_table . " ORDER BY date DESC LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();

// Check if a row is returned
if ($stmt->rowCount() > 0) {

    // Get the snapshot details
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Create an array with snapshot data
    $response = array(
        'status' => 'success',
        'statusMessage' => 'Snapshot récupérée.',
        'date' => $row["date"],
        'attendeesCount' => $row["attendeesCount"],
        'numberOfNewAttendees' => $row["numberOfNewAttendees"]
    );
} else {
    // Create an array with error message if no snapshot is found
    $response = array(
        'status' => 'error',
        'statusMessage' => 'Aucune snapshot trouvée.'
    );
}
echo json_encode($response); // Send response as JSON
?>
