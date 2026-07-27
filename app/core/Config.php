<?php
    class Config
    {
        public static function auth(): array
        {
            $jwtSecret = getenv('JWT_SECRET');

            if ($jwtSecret !== false) {
                return [
                    'jwt_secret' => $jwtSecret,
                    'jwt_ttl' => (int) (getenv('JWT_TTL') ?: 3600),
                    'mod_secret' => getenv('MOD_SECRET') ?: ''
                ];
            }

            return require __DIR__ . '/../config/auth.php';
        }

        public static function mail(): array
        {
            $host = getenv('MAIL_HOST');

            if ($host !== false) {
                return [
                    'host' => $host,
                    'port' => getenv('MAIL_PORT') ?: 587,
                    'username' => getenv('MAIL_USERNAME'),
                    'password' => getenv('MAIL_PASSWORD'),
                    'from_email' => getenv('MAIL_FROM_EMAIL'),
                    'from_name' => getenv('MAIL_FROM_NAME') ?: 'iACADEMY Confessions',
                    'app_url' => getenv('APP_URL') ?: 'http://localhost/iCONFESS/public/'
                ];
            }

            return require __DIR__ . '/../config/mail.php';
        }
    }
?>