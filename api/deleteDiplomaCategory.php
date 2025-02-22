<?php
include_once '../controllers/ApiController.php';
include_once '../class/DiplomaCategory.php';

class DeleteDiplomaCategoryController extends ApiController {
    public function __construct() {
        parent::__construct('POST', true); // Requires authentication
    }

    public function processRequest() {
        try {
            $id = intval($_POST['diplomaCategoryId']);
            $diplomaCategory = new DiplomaCategory($this->db);
            
            $response = $diplomaCategory->deleteDiplomaCategory($id);
            echo json_encode($response);
            
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new DeleteDiplomaCategoryController();
$controller->processRequest();
?>