<?php 
    class AuthMiddleware
    {
        public static function requireAuth()
        {
            $config = Config::auth();

            $token = null;
            $header = self::authorizationHeader();

            if (substr($header, 0, 7) === 'Bearer ') {
                $token = trim(substr($header, 7));
            } elseif (!empty($_COOKIE['jwt_token'])) {
                $token = $_COOKIE['jwt_token'];
            }

            if (!$token) {
                self::json(['message' => 'Bearer token required'], 401);
                exit;
            }

            $payload = Jwt::verify($token, $config['jwt_secret']);

            if (!$payload) {
                self::json(['message' => 'Invalid or expired token'], 401);
                exit;
            }

            return $payload;
        }
        
        // auth check that doesn't exit on failure
        // confession feed will still be visible regardless if there is a token
        public static function optionalAuth(): ?array
        {
            $config = Config::auth();

            $token = null;
            $header = self::authorizationHeader();

            if (substr($header, 0, 7) === 'Bearer ') {
                $token = trim(substr($header, 7));
            } elseif (!empty($_COOKIE['jwt_token'])) {
                $token = $_COOKIE['jwt_token'];
            }

            if (!$token) return null;

            $payload = Jwt::verify($token, $config['jwt_secret']);
            return $payload ?: null;
        }

        private static function authorizationHeader()
        {
            return $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
        }

        private static function json(array $data, int $status = 200)
        {
            http_response_code($status);
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
?>