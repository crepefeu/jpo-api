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
include_once '../class/DiplomaCategory.php';
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

$id = intval($_POST['id']); // Get the id from the POST request
$diplomaCategoryName = $_POST['diplomaCategoryName']; // Get the diploma category name from the POST request

$diplomaCategory = new DiplomaCategory($db); // Create a new diploma category object

// Set all diploma category values
$diplomaCategory->setAll($diplomaCategoryName);

$response = $diplomaCategory->modifyDiplomaCategory($id); // Modify the diploma category in the database

echo json_encode($response); // Send the response as JSON

?>