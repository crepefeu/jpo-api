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
include_once '../class/JWTHandler.php';

$database = new Database();
$db = $database->getConnection();

global $isAuth;
$isAuth = false;
$token = null;

// Get the token from the Authorization header
$headers = getallheaders();
if (isset($headers['Authorization'])) {
    $auth_header = $headers['Authorization'];
    // Check if it's a Bearer token
    if (preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) {
        $token = $matches[1];
    }
}

if ($token) {
    $jwt = new JWTHandler();
    $result = $jwt->validateToken($token);

    if ($result['valid'] && $result['user_id']) {
        $isAuth = true;
    }
} else {
    $isAuth = false;
}

echo json_encode($isAuth);