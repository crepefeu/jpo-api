<?php
require_once '../controllers/ApiController.php';

class TakeSnapshot extends ApiController
{
    public function __construct()
    {
        parent::__construct('GET', false);
    }

    public function processRequest()
    {
        // Get latest snapshot if there is one
        $query = "SELECT * FROM analyticsSnapshots ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get total number of attendees
        $query2 = "SELECT COUNT(*) FROM attendees";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->execute();
        $totalAttendees = $stmt2->fetchColumn();

        // Calculate new attendees and insert snapshot
        $newAttendees = $row ? $totalAttendees - $row['attendeesCount'] : 0;

        $query3 = "INSERT INTO analyticsSnapshots (attendeesCount, numberOfNewAttendees) 
                   VALUES (:attendeesCount, :numberOfNewAttendees)";
        $stmt3 = $this->db->prepare($query3);
        $stmt3->bindParam(":attendeesCount", $totalAttendees);
        $stmt3->bindParam(":numberOfNewAttendees", $newAttendees);
        $stmt3->execute();

        echo json_encode(['status' => 'success']);
    }
}

$controller = new TakeSnapshot();
$controller->processRequest();
