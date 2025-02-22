<?php
include_once '../controllers/ApiController.php';
include_once '../class/Diploma.php';

class DeleteDiplomaController extends ApiController {
    public function __construct() {
        parent::__construct('POST', true); // Requires authentication
    }

    public function processRequest() {
        try {
            $id = intval($_POST['diplomaId']);
            $diploma = new Diploma($this->db);
            
            $response = $diploma->deleteDiploma($id);
            echo json_encode($response);
            
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new DeleteDiplomaController();
$controller->processRequest();
?>