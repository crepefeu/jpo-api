<?php
require_once '../controllers/ApiController.php';
require_once '../class/JWTHandler.php';

class SaveUserPreferences extends ApiController {
    public function __construct() {
        parent::__construct('POST'); // requiresAuth defaults to true
    }

    public function processRequest() {
        $showPercentagesOnCharts = $_POST['showPercentagesOnCharts'] == "true" ? 1 : 0;
        $showLegendOnCharts = $_POST['showLegendOnCharts'] == "true" ? 1 : 0;
        $defaultTheme = $_POST['defaultTheme'];

        // Get user ID from JWT
        $headers = getallheaders();
        $jwt = preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches) ? $matches[1] : null;
        $jwtHandler = new JWTHandler();
        $userId = $jwtHandler->validateToken($jwt)['user_id'];

        // Update preferences
        $query = "UPDATE userPreferences SET 
            defaultTheme = :defaultTheme,
            showPercentagesOnCharts = :showPercentagesOnCharts,
            showLegendOnCharts = :showLegendOnCharts
            WHERE adminId = :adminId";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':showPercentagesOnCharts', $showPercentagesOnCharts);
        $stmt->bindParam(':showLegendOnCharts', $showLegendOnCharts);
        $stmt->bindParam(':defaultTheme', $defaultTheme);
        $stmt->bindParam(':adminId', $userId, PDO::PARAM_STR);
        $stmt->execute();

        // Get updated preferences
        $query = "SELECT * FROM userPreferences WHERE adminId = :adminId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':adminId', $userId, PDO::PARAM_STR);
        $stmt->execute();
        $preferences = $stmt->fetch(PDO::FETCH_ASSOC);

        // Convert boolean values
        foreach ($preferences as $key => $value) {
            if ($key != "adminId" && $key != "defaultTheme") {
                $preferences[$key] = $value == 1;
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Préférences enregistrées',
            'userPreferences' => $preferences
        ]);
    }
}

$controller = new SaveUserPreferences();
$controller->processRequest();
