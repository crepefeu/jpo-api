<?php
require_once '../controllers/ApiController.php';

class GetAllDiplomaCategoriesWithDiplomas extends ApiController {
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
            
            // Get diplomas for this category
            $query2 = "SELECT * FROM diplomaTypes WHERE categoryId = :categoryId";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bindParam(':categoryId', $id, PDO::PARAM_STR);
            $stmt2->execute();
            
            $diplomas = [];
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                extract($row2);
                $diplomas[] = array(
                    "id" => $id,
                    "name" => $diplomaName
                );
            }
            
            $diplomaCategories[] = array(
                "id" => $id,
                "name" => $categoryName,
                "diplomas" => $diplomas
            );
        }
        
        echo json_encode($diplomaCategories);
    }
}

$controller = new GetAllDiplomaCategoriesWithDiplomas();
$controller->processRequest();
?>