<?php
include_once '../controllers/ApiController.php';
include_once '../class/Diploma.php';

class AddDiplomaController extends ApiController {
    public function __construct() {
        parent::__construct('POST', true); // Requires authentication
    }

    public function processRequest() {
        try {
            $diploma = new Diploma($this->db);
            $diploma->setAll(
                intval($_POST['diplomaCategoryId']), 
                $_POST['diplomaName']
            );
            
            $response = $diploma->addDiploma();
            echo json_encode($response);
            
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new AddDiplomaController();
$controller->processRequest();