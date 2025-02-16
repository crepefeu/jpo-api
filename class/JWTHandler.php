<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler {
    private $jwt_secret;
    private $token_expiration;

    public function __construct() {
        $this->jwt_secret = Config::get('JWT_SECRET');
        $this->token_expiration = 24 * 3600; // 24 hours
    }

    public function generateToken($user_id) {
        $issuedAt = time();
        $expire = $issuedAt + $this->token_expiration;

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expire,
            'user_id' => $user_id
        ];

        return JWT::encode($payload, $this->jwt_secret, 'HS256');
    }

    public function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->jwt_secret, 'HS256'));
            return [
                'valid' => true,
                'user_id' => $decoded->user_id
            ];
        } catch (Exception $e) {
            return [
                'valid' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
