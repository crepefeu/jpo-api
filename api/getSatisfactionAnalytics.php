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

$satisfactionAnalytics = array(
    "labels" => [
        "Agréable",
        "Neutre",
        "Désagréable",
    ],
    "virtualTourSatisfaction" => [],
    "websiteSatisfaction" => [],
);

for ($i = 0; $i < 3; $i++) {
    // Query to get the virtual tour satisfaction count per option
    $query = "SELECT COUNT(*) AS satisfactionCount FROM " . $db_table . " WHERE virtualTourSatisfaction = " . $i;
    $stmt = $db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    // Append data to satisactionsAnalytics array
    array_push($satisfactionAnalytics["virtualTourSatisfaction"], $satisfactionCount); // Append satisfaction count to virtualTourSatisfaction array
}

for ($i = 0; $i < 3; $i++) {
    // Query to get the website satisfaction count per option
    $query = "SELECT COUNT(*) AS satisfactionCount FROM " . $db_table . " WHERE websiteSatisfaction = " . $i;
    $stmt = $db->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    // Append data to satisactionsAnalytics array
    array_push($satisfactionAnalytics["websiteSatisfaction"], $satisfactionCount); // Append satisfaction count to websiteSatisfaction array
}

echo json_encode($satisfactionAnalytics); // Send satisfactionAnalytics array as JSON response
