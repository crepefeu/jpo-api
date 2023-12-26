<?php
header("Access-Control-Allow-Origin: *"); // Allow access from any origin for CORS. TODO: Change this to the domain of the website when deploying
header("Content-Type: application/json; charset=UTF-8"); // Set the response type to JSON and set charset to UTF-8
header("Access-Control-Allow-Methods: POST"); // Allow POST method only

include_once '../config/Database.php';
include_once '../class/DiplomaCategory.php';

$database = new Database(); // Create a new database object
$db = $database->getConnection(); // Get database connection

$diplomaCategory = new DiplomaCategory($db); // Create a new diploma category object

$diplomaCategory->setAll($_POST['diplomaCategoryName']); // Set all values

$response = $diplomaCategory->addDiplomaCategory(); // Add the diploma category to the database

echo json_encode($response); // Send the response as JSON