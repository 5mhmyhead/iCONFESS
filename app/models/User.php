<?php
    class User
    {
        private ?int $id;
        private string $username;
        private string $email;
        private string $password;
        private string $role;

        public function __construct(
            ?int $id = null,
            string $username = '',
            string $email = '',
            string $password = '',
            string $role = 'user'
        ) {
            $this -> id = $id;
            $this -> username = $username;
            $this -> email = $email;
            $this -> password = $password;
            $this -> role = $role;
        }

        public function getId(): ?int { return $this -> id; }
        public function setId(?int $id): void { $this -> id = $id; }

        public function getUsername(): string { return $this -> username; }
        public function setUsername(string $username): void { $this -> username = $username; }

        public function getEmail(): string { return $this -> email; }
        public function setEmail(string $email): void { $this -> email = $email; }

        public function getPassword(): string { return $this -> password; }
        public function setPassword(string $password): void { $this -> password = $password; }

        public function getRole(): string { return $this -> role; }
        public function setRole(string $role): void { $this -> role = $role; }

        public function findByUsername(string $username): ?User
        {
            $pdo = Database::connect();
            $stmt = $pdo -> prepare('SELECT * FROM users WHERE username = ?');
            $stmt -> execute([$username]);
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User(
                    $row['id'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['role']
                );
            }   

            return null;
        }

        public function register(string $username, string $email, string $password, string $role): bool
        {
            $pdo = Database::connect();

            $stmt = $pdo -> prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
            return $stmt -> execute([$username, $email, $password, $role]);
        }

        public static function findByEmail(string $email): ?User
        {
            $pdo = Database::connect();
            $stmt = $pdo -> prepare('SELECT * FROM users WHERE email = ?');
            $stmt -> execute([$email]);
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) 
            {
                return new User($row['id'], $row['username'], $row['email'], $row['password'], $row['role']);
            }

            return null;
        }

        public function updatePassword(int $userId, string $hashedPassword): bool
        {
            $pdo = Database::connect();
            $stmt = $pdo -> prepare('UPDATE users SET password = ? WHERE id = ?');
            return $stmt -> execute([$hashedPassword, $userId]);
        }

        public function getAccountsLive(): int
        {
            $pdo = Database::connect();

            $totalStmt = $pdo -> query("SELECT COUNT(*) FROM users");
            $accountsLive = (int) $totalStmt -> fetchColumn();

            return $accountsLive;
        }

        public static function countAllUsers(): int
        {
            $pdo = Database::connect();
            return (int) $pdo -> query("SELECT COUNT(*) FROM users") -> fetchColumn();
        }

        public static function countUsersThisWeek(): int
        {
            $pdo = Database::connect();
            return (int) $pdo -> query(
                "SELECT COUNT(*) FROM users WHERE created_at >= NOW() - INTERVAL 7 DAY"
            ) -> fetchColumn();
        }
    }
?>