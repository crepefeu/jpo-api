<?php
include_once '../controllers/ApiController.php';
include_once '../class/Attendee.php';

class DeleteAttendeeController extends ApiController {
    public function __construct() {
        parent::__construct('POST', true); // Requires authentication
    }

    public function processRequest() {
        try {
            $id = intval($_POST['attendeeId']);
            $attendee = new Attendee($this->db);
            
            $response = $attendee->deleteAttendee($id);
            echo json_encode($response);
            
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new DeleteAttendeeController();
$controller->processRequest();
?>