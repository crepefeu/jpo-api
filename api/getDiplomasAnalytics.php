<?php
include_once '../controllers/ApiController.php';
header("Access-Control-Allow-Origin: " . Config::get('WEBAPP_URL'));

class DiplomasAnalyticsController extends ApiController {
    public function __construct() {
        parent::__construct('GET');
    }

    public function processRequest() {
        $db_table = "diplomaTypes";
        $diplomas = array(
            "names" => [],
            "counts" => [],
        );

        $query = "SELECT 
            diplomaTypes.id as diplomaId, 
            diplomaTypes.diplomaName, 
            diplomaCategories.id as categoryId,
            diplomaCategories.categoryName 
        FROM " . $db_table . " 
        INNER JOIN diplomaCategories ON diplomaTypes.categoryId = diplomaCategories.id 
        ORDER BY diplomaTypes.diplomaName ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $diplomaId = preg_replace('/\s+/', '', $row['diplomaId']);
            $diplomaName = $row['diplomaName'];

            $query2 = "SELECT COUNT(*) AS diplomaCount FROM attendees WHERE diplomaId = :id";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bindParam(':id', $diplomaId, PDO::PARAM_STR);
            $stmt2->execute();
            
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $diplomaCount = (int)$row2['diplomaCount'];
            
            if ($diplomaCount > 0) {
                array_push($diplomas["names"], $diplomaName);
                array_push($diplomas["counts"], $diplomaCount);
            }
        }
        
        echo json_encode($diplomas);
    }
}

$controller = new DiplomasAnalyticsController();
$controller->processRequest();
?>

