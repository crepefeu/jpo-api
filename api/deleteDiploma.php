<?php
header("Access-Control-Allow-Origin: *"); // Allow access from any origin for CORS. TODO: Change this to the domain of the website when deploying
header("Content-Type: application/json; charset=UTF-8"); // Set the response type to JSON and set charset to UTF-8
header("Access-Control-Allow-Methods: POST"); // Allow POST method only

include_once '../config/Database.php';
include_once '../class/Diploma.php';

$database = new Database(); // Create a new database object
$db = $database->getConnection(); // Get database connection

$id = intval($_POST['diplomaId']); // Get the id from the POST request

$diploma = new Diploma($db); // Create a new attendee object

$response = $diploma->deleteDiploma($id); // Delete the attendee from the database

echo json_encode($response); // Send the response as JSON

?>