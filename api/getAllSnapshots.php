<?php
include_once '../controllers/ApiController.php';

class SnapshotsController extends ApiController {
    public function __construct() {
        parent::__construct('GET');
    }

    public function processRequest() {
        $snapshots = array(
            "dates" => [],
            "attendeesCounts" => [],
            "numberOfNewAttendees" => []
        );

        try {
            $query = "SELECT * FROM analyticsSnapshots ORDER BY date ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Go through each row
                extract($row); // Extract row data
            
                array_push($snapshots["dates"], $date); // Append snapshot date to snapshots array
                array_push($snapshots["attendeesCounts"], $attendeesCount); // Append snapshot attendeesCount to snapshots array
                array_push($snapshots["numberOfNewAttendees"], $numberOfNewAttendees); // Append snapshot numberOfNewAttendees to snapshots array
            }
            echo json_encode($snapshots);
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new SnapshotsController();
$controller->processRequest();
?>