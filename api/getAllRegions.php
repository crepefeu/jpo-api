<?php
include_once '../controllers/ApiController.php';

class RegionsController extends ApiController {
    public function __construct() {
        parent::__construct('GET', false); // Set requiresAuth to false for public access
    }

    public function processRequest() {
        try {
            $query = "SELECT * FROM regions";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            $regions = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $region = array(
                    "code" => $code,
                    "name" => $name
                );
                $regions[] = $region;
            }
            echo json_encode($regions);
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new RegionsController();
$controller->processRequest();
?>