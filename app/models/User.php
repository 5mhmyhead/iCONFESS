<?php
    class User
    {
        private $id;
        private $username;
        private $password;
    
        public function __construct($id = '', $username = '', $password = '')
        {
            $this -> id = $id;
            $this -> username = $username;
            $this -> password = $password;
        }

        public function getId() { return $this -> id; }
        public function setId($id) { $this -> id = $id; }

        public function getUsername() { return $this -> username; }
        public function setUsername($username) { $this -> username = $username; }

        public function getPassword() { return $this -> password; }
        public function setPassword($password) { $this -> password = $password; }

        public function findByUsername($username)
        {
            $pdo = Database::connect();
            $stmt = $pdo -> prepare('SELECT id, username, password FROM users WHERE username = ?');
            $stmt -> execute([$username]);
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row) {
                return new User($row['id'], $row['username'], $row['password']);
            }   

            return null;
        }

        public function addUser($username, $password)
        {
            $pdo = Database::connect();
            $stmt = $pdo -> prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            return $stmt -> execute([$username, $password]);
        }
    }
?>