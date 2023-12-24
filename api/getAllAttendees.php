<?php
header("Access-Control-Allow-Origin: *"); // Allow access from any origin for CORS. TODO: Change this to the domain of the website when deploying
header("Content-Type: application/json; charset=UTF-8"); // Set the response type to JSON and set charset to UTF-8
header("Access-Control-Allow-Methods: GET"); // Allow GET method only

include_once '../config/Database.php';

$database = new Database(); // Create a new database object
$db = $database->getConnection(); // Get database connection
$db_table = "attendees"; // Set the database table name

$attendees = array(); // Create an array to store attendees data

$query = "SELECT * FROM " . $db_table; // Query to get all attendees
$irlAttendeesQuery = "SELECT * FROM " . $db_table . " WHERE isIrlAttendee = 1"; // Query to get all IRL attendees

$irlAttendeesStmt = $db->prepare($irlAttendeesQuery);
$irlAttendeesStmt->execute();
$irlAttendeesCount = $irlAttendeesStmt->rowCount(); // Get the number of IRL attendees

$attendees["irlAttendeesCount"] = $irlAttendeesCount; // Append IRL attendees count to attendees array

$stmt = $db->prepare($query);
$stmt->execute();
$attendeesCount = $stmt->rowCount(); // Get the number of attendees
$attendees["totalAttendeesCount"] = $attendeesCount; // Append attendees count to attendees array

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Go through each row
    extract($row); // Extract row data

    // Create an array with attendee data and if isIrlAttendee is 1 then set the value to true otherwise set it to false
    $attendee = array(
        "id" => $id,
        "firstName" => $firstName,
        "lastName" => $lastName,
        "email" => $email,
        "diplomaId" => $diplomaId,
        "diplomaCategoryId" => $diplomaCategoryId,
        "isIrlAttendee" => $isIrlAttendee == 1 ? true : false,
        "regionalCode" => $regionalCode,
        "virtualTourSatisfaction" => $virtualTourSatisfaction,
        "websiteSatisfaction" => $websiteSatisfaction
    );

    $attendees["dataList"][] = $attendee; // Append attendee data to attendees array
}

echo json_encode($attendees); // Send attendees array as JSON response
?>
