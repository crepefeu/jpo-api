<?php
include_once '../controllers/ApiController.php';

class GetAllAttendees extends ApiController
{
    public function __construct()
    {
        parent::__construct('GET', true);
    }

    public function processRequest()
    {
        try {
            $db_table = "attendees";
            $attendees = array();

            $query = "SELECT * FROM " . $db_table;
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $attendee = array(
                    "id" => $id,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "email" => $email,
                    "diplomaId" => $diplomaId,
                    "diplomaCategoryId" => $diplomaCategoryId,
                    "isIrlAttendee" => $isIrlAttendee == 1 ? true : false,
                    "regionalCode" => $regionalCode,
                    "virtualTourSatisfaction" => $virtualTourSatisfaction,
                    "websiteSatisfaction" => $websiteSatisfaction
                );
                $attendees[] = $attendee;
            }

            echo json_encode($attendees);
        } catch (Exception $e) {
            $this->sendError($e);
        }
    }
}

$controller = new GetAllAttendees();
$controller->processRequest();