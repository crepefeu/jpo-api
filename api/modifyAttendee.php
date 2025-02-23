<?php
include_once '../controllers/ApiController.php';
include_once '../class/Attendee.php';

class ModifyAttendeeController extends ApiController {
    public function __construct() {
        parent::__construct('POST', true); // Set requiresAuth to true for protected access
    }

    public function processRequest() {
        try {
            $id = intval($_POST['id']);
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $diplomaId = intval($_POST['diplomaId']);
            $diplomaCategoryId = intval($_POST['diplomaCategoryId']);
            $isIrlAttendee = $_POST['isIrlAttendee'] == "true" ? 1 : 0;
            $regionalCode = $_POST['regionalCode'];

            $attendee = new Attendee($this->db);
            $attendee->setAllValues($firstName, $lastName, $email, $diplomaId, $diplomaCategoryId, $isIrlAttendee, $regionalCode, null, null);
            
            $response = $attendee->updateAttendee($id);
            echo json_encode($response);
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new ModifyAttendeeController();
$controller->processRequest();
?>