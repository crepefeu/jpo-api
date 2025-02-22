<?php
require_once '../controllers/ApiController.php';

class GetAllDiplomaCategories extends ApiController {
    public function __construct() {
        parent::__construct('GET', false);
    }

    public function processRequest() {
        $query = "SELECT * FROM diplomaCategories ORDER BY id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $diplomaCategories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $diplomaCategories[] = array(
                "id" => $id,
                "name" => $categoryName
            );
        }
        
        echo json_encode($diplomaCategories);
    }
}

$controller = new GetAllDiplomaCategories();
$controller->processRequest();
?>