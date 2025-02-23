<?php
include_once '../controllers/ApiController.php';

class DiplomasController extends ApiController {
    public function __construct() {
        parent::__construct('GET', false);
    }

    public function processRequest() {
        try {
            $query = "SELECT 
                        dt.id as diplomaId,
                        dt.diplomaName as diplomaName,
                        dc.id as categoryId,
                        dc.categoryName as categoryName
                    FROM diplomaTypes dt
                    INNER JOIN diplomaCategories dc ON dt.categoryId = dc.id 
                    ORDER BY dt.id ASC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $diplomasTypes = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $diplomaType = array(
                    "id" => $row['diplomaId'],
                    "name" => $row['diplomaName'],
                    "category" => array(
                        "id" => $row['categoryId'],
                        "name" => $row['categoryName']
                    )
                );
                $diplomasTypes[] = $diplomaType;
            }
            echo json_encode($diplomasTypes);
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new DiplomasController();
$controller->processRequest();
?>

