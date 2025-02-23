<?php
require_once '../controllers/ApiController.php';
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExportAttendees extends ApiController {
    public function __construct() {
        parent::__construct('GET'); // requiresAuth defaults to true
    }

    public function processRequest() {
        $query = "SELECT * FROM attendees";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers and column widths
        $headers = [
            'A' => ['ID', 10],
            'B' => ['Prenom', 20],
            'C' => ['Nom', 20],
            'D' => ['Email', 50],
            'E' => ['Diplome', 20],
            'F' => ['Categorie de diplome', 20],
            'G' => ['Participation', 20],
            'H' => ['Region', 30],
            'I' => ['Satisfaction visite virtuelle', 30],
            'J' => ['Satisfaction site web', 20]
        ];

        foreach ($headers as $col => $settings) {
            $sheet->setCellValue($col . '1', $settings[0]);
            $sheet->getColumnDimension($col)->setWidth($settings[1]);
        }

        $row = 2;
        while ($row_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Get diploma name
            $stmt2 = $this->db->prepare("SELECT diplomaName FROM diplomaTypes WHERE id = :id");
            $stmt2->bindParam(':id', $row_data['diplomaId']);
            $stmt2->execute();
            $diplomaName = $stmt2->fetch(PDO::FETCH_ASSOC)['diplomaName'];

            // Get category name
            $stmt2 = $this->db->prepare("SELECT categoryName FROM diplomaCategories WHERE id = :id");
            $stmt2->bindParam(':id', $row_data['diplomaCategoryId']);
            $stmt2->execute();
            $diplomaCategoryName = $stmt2->fetch(PDO::FETCH_ASSOC)['categoryName'];

            // Get region name
            $stmt2 = $this->db->prepare("SELECT name FROM regions WHERE code = :code");
            $stmt2->bindParam(':code', $row_data['regionalCode']);
            $stmt2->execute();
            $regionName = $stmt2->fetch(PDO::FETCH_ASSOC)['name'];

            $satisfactionMap = [0 => "Agréable", 1 => "Neutre", 2 => "Désagréable"];
            
            $sheet->setCellValue('A' . $row, $row_data['id'])
                  ->setCellValue('B' . $row, $row_data['firstName'])
                  ->setCellValue('C' . $row, $row_data['lastName'])
                  ->setCellValue('D' . $row, $row_data['email'])
                  ->setCellValue('E' . $row, $diplomaName)
                  ->setCellValue('F' . $row, $diplomaCategoryName)
                  ->setCellValue('G' . $row, $row_data['isIrlAttendee'] ? "Présentielle" : "Distancielle")
                  ->setCellValue('H' . $row, $regionName)
                  ->setCellValue('I' . $row, $satisfactionMap[$row_data['virtualTourSatisfaction']] ?? '')
                  ->setCellValue('J' . $row, $satisfactionMap[$row_data['websiteSatisfaction']] ?? '');
            $row++;
        }

        $fileName = 'liste_des_participants_jpo_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('../documents/' . $fileName);

        echo json_encode([
            "status" => "success",
            "message" => "Le fichier a été exporté avec succès",
            "fileName" => $fileName
        ]);
    }
}

$controller = new ExportAttendees();
$controller->processRequest();
?>