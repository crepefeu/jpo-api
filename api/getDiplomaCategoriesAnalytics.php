<?php
include_once '../controllers/ApiController.php';

class DiplomaCategoriesAnalyticsController extends ApiController {
    public function __construct() {
        parent::__construct('GET');
    }

    public function processRequest() {
        $db_table = "diplomaCategories";
        $diplomaCategories = array(
            "names" => [],
            "counts" => [],
        );

        $query = "SELECT * FROM " . $db_table . " ORDER BY categoryName ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $categoryName = $row['categoryName'];

            $query2 = "SELECT COUNT(*) AS diplomaCategoryCount FROM attendees WHERE diplomaCategoryId = :categoryId";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bindParam(':categoryId', $id, PDO::PARAM_STR);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            $diplomaCategoryCount = $row2['diplomaCategoryCount'];

            if ($diplomaCategoryCount > 0) {
                array_push($diplomaCategories["names"], $categoryName);
                array_push($diplomaCategories["counts"], $diplomaCategoryCount);
            }
        }

        echo json_encode($diplomaCategories);
    }
}

$controller = new DiplomaCategoriesAnalyticsController();
$controller->processRequest();