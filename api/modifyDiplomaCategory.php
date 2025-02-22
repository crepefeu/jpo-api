<?php
require_once '../controllers/ApiController.php';
require_once '../class/DiplomaCategory.php';

class ModifyDiplomaCategory extends ApiController {
    public function __construct() {
        parent::__construct('POST'); // requiresAuth defaults to true
    }

    public function processRequest() {
        $id = intval($_POST['id']);
        $diplomaCategoryName = $_POST['diplomaCategoryName'];

        $diplomaCategory = new DiplomaCategory($this->db);
        $diplomaCategory->setAll($diplomaCategoryName);
        $response = $diplomaCategory->modifyDiplomaCategory($id);

        echo json_encode($response);
    }
}

$controller = new ModifyDiplomaCategory();
$controller->processRequest();
?>