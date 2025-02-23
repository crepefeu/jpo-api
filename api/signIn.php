<?php
require_once '../controllers/ApiController.php';
require_once '../class/Admin.php';
require_once '../class/JWTHandler.php';

class SignIn extends ApiController {
    public function __construct() {
        parent::__construct('POST', false);
    }

    public function processRequest() {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $admin = new Admin($this->db, $login, $password);
        $response = $admin->login();

        if ($response['status'] === 'success') {
            $jwt = new JWTHandler();
            $token = $jwt->generateToken($response['id']);
            $response['token'] = $token;
        }

        echo json_encode($response);
    }
}

$controller = new SignIn();
$controller->processRequest();
?>