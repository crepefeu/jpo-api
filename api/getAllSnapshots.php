<?php
header("Access-Control-Allow-Origin: *"); // Allow cross-origin requests from any domain TODO: Change this to the domain of the website when deploying
header("Content-Type: application/json; charset=UTF-8"); // Set the response type to JSON and set charset to UTF-8
header("Access-Control-Allow-Methods: GET"); // Allow GET method only

include_once '../config/Database.php';

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