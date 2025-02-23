<?php
require_once '../controllers/ApiController.php';
require_once '../class/Attendee.php';

class RegisterAttendee extends ApiController {
    public function __construct() {
        parent::__construct('POST', false);
    }

    public function processRequest() {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $diplomaId = intval($_POST['diplomaId']);
        $diplomaCategoryId = intval($_POST['diplomaCategoryId']);
        $isIrlAttendee = $_POST['isIrlAttendee'] == "true" ? 1 : 0;
        $regionalCode = $_POST['regionalCode'];
        
        $virtualTourSatisfaction = isset($_POST['virtualTourSatisfaction']) ? 
            intval($_POST['virtualTourSatisfaction']) : null;
        $websiteSatisfaction = isset($_POST['websiteSatisfaction']) ? 
            intval($_POST['websiteSatisfaction']) : null;

        $attendee = new Attendee($this->db);
        $attendee->setAllValues(
            $firstName, 
            $lastName, 
            $email, 
            $diplomaId, 
            $diplomaCategoryId, 
            $isIrlAttendee, 
            $regionalCode, 
            $virtualTourSatisfaction, 
            $websiteSatisfaction
        );

        $response = $attendee->createAttendee();
        echo json_encode($response);
    }
}

$controller = new RegisterAttendee();
$controller->processRequest();
?>
