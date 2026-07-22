<?php
    class PasswordReset
    {
        public function create(int $userId, string $token, int $ttlSeconds = 1800): int
        {
            $pdo = Database::connect();

            $stmt = $pdo -> prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND))");
            $stmt -> execute([$userId, $token, $ttlSeconds]);
            
            return (int) $pdo -> lastInsertId();
        }

        public function findValidByToken(string $token): ?array
        {
            $pdo = Database::connect();

            $stmt = $pdo -> prepare("SELECT * FROM password_resets WHERE token = ? AND used = FALSE AND expires_at > NOW()");
            $stmt -> execute([$token]);

            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        }

        public function markUsed(int $id): bool
        {
            $pdo = Database::connect();
            
            $stmt = $pdo -> prepare("UPDATE password_resets SET used = TRUE WHERE id = ?");
            return $stmt -> execute([$id]);
        }
    }
?>