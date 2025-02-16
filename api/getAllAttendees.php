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
$db_table = "attendees"; // Set the database table name

$attendees = array(); // Create an array to store attendees data

$query = "SELECT * FROM " . $db_table; // Query to get all attendees

$stmt = $db->prepare($query);
$stmt->execute();

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

    $attendees[] = $attendee; // Append attendee data to attendees array
}

echo json_encode($attendees); // Send attendees array as JSON response
?>
