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
$db_table = "analyticsSnapshots"; // Set the database table name

// Initialize snapshots array to store all snapshots
$snapshots = array(
    "dates" => [],
    "attendeesCounts" => [],
    "numberOfNewAttendees" => []
);

// Query to get all snapshots ordered by date from oldest to newest
$query = "SELECT * FROM " . $db_table . " ORDER BY date ASC";
$stmt = $db->prepare($query);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Go through each row
    extract($row); // Extract row data

    array_push($snapshots["dates"], $date); // Append snapshot date to snapshots array
    array_push($snapshots["attendeesCounts"], $attendeesCount); // Append snapshot attendeesCount to snapshots array
    array_push($snapshots["numberOfNewAttendees"], $numberOfNewAttendees); // Append snapshot numberOfNewAttendees to snapshots array
}
echo json_encode($snapshots); // Send snapshots array as JSON response
?>