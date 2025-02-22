<?php
include_once '../controllers/ApiController.php';

class SatisfactionAnalyticsController extends ApiController {
    public function __construct() {
        parent::__construct('GET');
    }

    public function processRequest() {
        try {
            $db_table = "attendees";

            $satisfactionAnalytics = array(
                "labels" => [
                    "Agréable",
                    "Neutre",
                    "Désagréable",
                ],
                "virtualTourSatisfaction" => [],
                "websiteSatisfaction" => [],
            );

            for ($i = 0; $i < 3; $i++) {
                $query = "SELECT COUNT(*) AS satisfactionCount FROM " . $db_table . " WHERE virtualTourSatisfaction = " . $i;
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $satisfactionAnalytics["virtualTourSatisfaction"][] = $row['satisfactionCount'];
            }

            for ($i = 0; $i < 3; $i++) {
                $query = "SELECT COUNT(*) AS satisfactionCount FROM " . $db_table . " WHERE websiteSatisfaction = " . $i;
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $satisfactionAnalytics["websiteSatisfaction"][] = $row['satisfactionCount'];
            }

            echo json_encode($satisfactionAnalytics);
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new SatisfactionAnalyticsController();
$controller->processRequest();
