<?php
include_once '../class/JWTHandler.php';

class JWTMiddleware {
    public static function validateToken() {
        $token = null;
        $headers = getallheaders();
        
        if (isset($headers['Authorization'])) {
            $auth_header = $headers['Authorization'];
            if (preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) {
                $token = $matches[1];
            }
        }

        if (!$token) {
            http_response_code(403);
            echo json_encode(["message" => "No token provided"]);
            exit();
        }

        $jwt = new JWTHandler();
        $result = $jwt->validateToken($token);
        
        if (!$result['valid'] || !$result['user_id']) {
            http_response_code(401);
            exit();
        }
    }
}
