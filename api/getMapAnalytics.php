<?php
include_once '../controllers/ApiController.php';

class MapAnalyticsController extends ApiController {
    public function __construct() {
        parent::__construct('GET');
    }

    public function processRequest() {
        try {
            $regions = [];
            $db_table = "regions";

            $query = "SELECT * FROM " . $db_table;
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $query2 = "SELECT COUNT(*) AS attendeeCount FROM attendees WHERE regionalCode = :code";
                $stmt2 = $this->db->prepare($query2);
                $stmt2->bindParam(':code', $row['code']);
                $stmt2->execute();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                $regions[] = [
                    $row["code"],
                    $row2["attendeeCount"]
                ];
            }

            echo json_encode($regions);
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new MapAnalyticsController();
$controller->processRequest();


