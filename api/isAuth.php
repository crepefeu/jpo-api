<?php
include_once '../controllers/ApiController.php';

class IsAuthController extends ApiController {
    public function __construct() {
        parent::__construct('GET', true, true);
    }

    public function processRequest() {
        try {
            $isAuth = false;
            $token = null;
            
            $headers = getallheaders();
            if (!isset($headers['Authorization'])) {
                echo json_encode([
                    'isAuthenticated' => false,
                    'reason' => 'Invalid token'
                ]);
                return;
            }

            $auth_header = $headers['Authorization'];
            if (!preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) {
                echo json_encode([
                    'isAuthenticated' => false,
                    'reason' => 'Invalid token'
                ]);
                return;
            }

            $token = $matches[1];
            $jwt = new JWTHandler();
            $result = $jwt->validateToken($token);
            $isAuth = $result['valid'] && !empty($result['user_id']);

            echo json_encode([
                'isAuthenticated' => $isAuth,
                'reason' => $isAuth ? 'Valid token' : 'Invalid token',
            ]);
            
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new IsAuthController();
$controller->processRequest();