<?php
include_once '../config/Config.php';
include_once '../config/Database.php';
include_once '../middleware/JWTMiddleware.php';

abstract class ApiController
{
    protected $db;
    protected $method;
    protected $requiresAuth;

    public function __construct($allowedMethod, $requiresAuth = true)
    {
        // Set CORS headers first, before any potential errors
        header("Access-Control-Allow-Origin: " . Config::get('WEBAPP_URL'));
        header("Access-Control-Allow-Methods: OPTIONS, " . $allowedMethod);
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        header("Access-Control-Max-Age: 3600");

        // Handle preflight OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Content-Length: 0");
            header("Content-Type: text/plain");
            exit(0);
        }

        // Set security headers
        header("Strict-Transport-Security: includeSubDomains");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Content-Security-Policy: default-src 'self'");
        header("Content-Type: application/json; charset=UTF-8");

        // Initialize database connection
        try {
            $database = new Database();
            $this->db = $database->getConnection();
            $this->method = $allowedMethod;
            $this->requiresAuth = $requiresAuth;

            if ($requiresAuth) {
                JWTMiddleware::validateToken();
            }
        } catch (Exception $e) {
            $this->sendError($e);
            exit;
        }
    }

    protected function sendError($e)
    {
        $response = [
            'error' => true,
            'message' => $e->getMessage()
        ];

        if (Config::get('DEBUG_MODE')) {
            $response['debug'] = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
        }

        echo json_encode($response);
    }

    abstract public function processRequest();
}
