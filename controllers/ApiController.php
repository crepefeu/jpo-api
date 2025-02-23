<?php
include_once '../config/Config.php';
include_once '../config/Database.php';
include_once '../middleware/JWTMiddleware.php';
include_once '../middleware/RateLimiter.php';

abstract class ApiController
{
    protected $db;
    protected $method;
    protected $requiresAuth;
    protected $rateLimiter;
    protected $useRateLimit;

    public function __construct($allowedMethod, $requiresAuth = true, $useRateLimit = true)
    {
        // Always set CORS headers first, before anything else
        header("Access-Control-Allow-Origin: " . Config::get('WEBAPP_URL'));
        header("Access-Control-Allow-Methods: OPTIONS, " . $allowedMethod);
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Expose-Headers: X-RateLimit-Limit, X-RateLimit-Remaining, X-RateLimit-Reset, Retry-After");

        // Handle preflight OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit();
        }

        // Check rate limit after CORS is handled
        if ($useRateLimit) {
            $this->useRateLimit = true;
            $this->rateLimiter = new RateLimiter(
                Config::get('RATE_LIMIT_WINDOW'),
                Config::get('RATE_LIMIT_MAX_REQUESTS')
            );
            
            $clientIp = $_SERVER['REMOTE_ADDR'];
            list($allowed, $remaining) = $this->rateLimiter->checkLimit($clientIp);

            header('X-RateLimit-Limit: ' . Config::get('RATE_LIMIT_MAX_REQUESTS'));
            header('X-RateLimit-Remaining: ' . max(0, $remaining));
            header('X-RateLimit-Reset: ' . (time() + Config::get('RATE_LIMIT_WINDOW')));
            
            if (!$allowed) {
                http_response_code(429);
                header('Retry-After: ' . Config::get('RATE_LIMIT_WINDOW'));
                header('Content-Type: application/json');
                echo json_encode([
                    'error' => true,
                    'message' => 'Rate limit exceeded. Please try again later.',
                    'debug' => [
                        'ip' => $clientIp,
                        'remaining' => $remaining,
                        'window' => Config::get('RATE_LIMIT_WINDOW'),
                        'max' => Config::get('RATE_LIMIT_MAX_REQUESTS')
                    ]
                ]);
                exit();
            }
        }

        // Set remaining security headers
        header("Strict-Transport-Security: includeSubDomains");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Content-Security-Policy: default-src 'self'");
        header("Content-Type: application/json; charset=UTF-8");

        try {
            $database = new Database();
            $this->db = $database->getConnection();
            $this->method = $allowedMethod;
            $this->requiresAuth = $requiresAuth;

            if ($requiresAuth) {
                JWTMiddleware::validateToken();
            }
        } catch (Exception $e) {
            http_response_code(500);
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
