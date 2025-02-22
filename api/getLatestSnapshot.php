<?php
include_once '../controllers/ApiController.php';

class LatestSnapshotController extends ApiController {
    public function __construct() {
        parent::__construct('GET');
    }

    public function processRequest() {
        $db_table = "analyticsSnapshots";
        
        $query = "SELECT * FROM " . $db_table . " ORDER BY date DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $response = array(
                'status' => 'success',
                'statusMessage' => 'Snapshot récupérée.',
                'date' => $row["date"],
                'attendeesCount' => $row["attendeesCount"],
                'numberOfNewAttendees' => $row["numberOfNewAttendees"]
            );
        } else {
            $response = array(
                'status' => 'error',
                'statusMessage' => 'Aucune snapshot trouvée.'
            );
        }
        
        echo json_encode($response);
    }
}

$controller = new LatestSnapshotController();
$controller->processRequest();
?>
