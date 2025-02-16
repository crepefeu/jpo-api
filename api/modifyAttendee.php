<?php
include_once '../config/Config.php';
header("Strict-Transport-Security: includeSubDomains");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self'");

header("Access-Control-Allow-Origin: " . Config::get('WEBAPP_URL'));
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/Attendee.php';
include_once '../middleware/JWTMiddleware.php';

JWTMiddleware::validateToken();

$database = new Database(); // Create a new database object
$db = $database->getConnection(); // Get database connection

$id = intval($_POST['id']); // Get the id from the POST request
$firstName = $_POST['firstName']; // Get the first name from the POST request
$lastName = $_POST['lastName']; // Get the last name from the POST request
$email = $_POST['email']; // Get the email from the POST request
$diplomaId = intval($_POST['diplomaId']); // Get the diploma id from the POST request
$diplomaCategoryId = intval($_POST['diplomaCategoryId']); // Get the diploma category id from the POST request
$isIrlAttendee = $_POST['isIrlAttendee'] == "true"? 1 : 0; // if $_POST['isIrlAttendee'] is true then set $isIrlAttendee to 1 otherwise set it to 0
$regionalCode = $_POST['regionalCode']; // Get the regional code from the POST request

$attendee = new Attendee($db); // Create a new attendee object

// Set all attendee values
$attendee->setAllValues($firstName, $lastName, $email, $diplomaId, $diplomaCategoryId, $isIrlAttendee, $regionalCode, null, null);

$response = $attendee->updateAttendee($id); // Delete the attendee from the database

echo json_encode($response); // Send the response as JSON

?>