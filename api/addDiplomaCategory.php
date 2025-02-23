<?php
include_once '../controllers/ApiController.php';
include_once '../class/DiplomaCategory.php';

class AddDiplomaCategoryController extends ApiController {
    public function __construct() {
        parent::__construct('POST', true); // Requires authentication
    }

    public function processRequest() {
        try {
            $diplomaCategory = new DiplomaCategory($this->db);
            $diplomaCategory->setAll($_POST['diplomaCategoryName']);
            
            $response = $diplomaCategory->addDiplomaCategory();
            echo json_encode($response);
            
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new AddDiplomaCategoryController();
$controller->processRequest();