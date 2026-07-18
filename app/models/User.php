<?php
    class User
    {
        private ?int $id;
        private string $username;
        private string $password;
        private string $role;

        public function __construct(
            ?int $id = null,
            string $username = '',
            string $password = '',
            string $role = 'user'
        ) {
            $this -> id = $id;
            $this -> username = $username;
            $this -> password = $password;
            $this -> role = $role;
        }

        public function getId(): ?int { return $this -> id; }
        public function setId(?int $id): void { $this -> id = $id; }

        public function getUsername(): string { return $this -> username; }
        public function setUsername(string $username): void { $this -> username = $username; }

        public function getPassword(): string { return $this -> password; }
        public function setPassword(string $password): void { $this -> password = $password; }

        public function getRole(): string { return $this -> role; }
        public function setRole(string $role): void { $this -> role = $role; }

        public static function findByUsername(string $username): ?User
        {
            $pdo = Database::connect();
            $stmt = $pdo -> prepare('SELECT * FROM users WHERE username = ?');
            $stmt -> execute([$username]);
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User(
                    $row['id'],
                    $row['username'],
                    $row['password'],
                    $row['role']
                );
            }   

            return null;
        }

        public function register(string $username, string $password, string $role): bool
        {
            $pdo = Database::connect();

            $stmt = $pdo -> prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
            return $stmt -> execute([$username, $password, $role]);
        }
    }
?>