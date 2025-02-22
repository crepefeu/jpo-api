<?php
include_once '../controllers/ApiController.php';
include_once '../class/Diploma.php';

class ModifyDiplomaController extends ApiController {
    public function __construct() {
        parent::__construct('POST');
    }

    public function processRequest() {
        $id = intval($_POST['id']);
        $diplomaName = $_POST['diplomaName'];
        $diplomaCategoryId = intval($_POST['diplomaCategoryId']);

        $diploma = new Diploma($this->db);
        $diploma->setAll($diplomaCategoryId, $diplomaName);
        $response = $diploma->modifyDiploma($id);

        return $response;
    }
}

$controller = new ModifyDiplomaController();
echo json_encode($controller->processRequest());
?>