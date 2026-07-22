<?php
    class AuthService
    {
        private User $userModel;

        public function __construct()
        {
            $this -> userModel = new User();
        }

        public function registerUser(string $email, string $username, string $password, string $role = 'user'): array
        {
            $email = trim($email);
            $username = trim($username);
            $password = trim($password);
            $role = trim($role);

            $domain = '@iacademy.edu.ph';

            if ($username === '' || $email === '' || $password === '') {
                return ['success' => false, 'message' => 'Registration failed. All fields are required.'];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Registration failed. Invalid email format.'];
            }

            if ($this -> userModel -> findByUsername($username)) {
                return ['success' => false, 'message' => 'Registration failed. That username is already taken.'];
            }

            if (empty($email) || substr($email, -strlen($domain)) !== $domain) {
                return ['success' => false, 'message' => 'Registration is restricted to @iacademy.edu.ph email addresses.'];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $created = $this -> userModel -> register($username, $email, $hashedPassword, $role);
            return ['success' => $created, 'message' => $created ? 'Registration successful.' : 'Registration failed.'];
        }

        public function loginUser(string $username, string $password): array
        {
            $username = trim($username);
            $password = trim($password);

            if ($username === '' || $password === '') 
            {
                return ['success' => false, 'message' => 'Username and password are required.'];
            }

            $user = $this -> userModel -> findByUsername($username);

            if (!$user || !password_verify($password, $user -> getPassword())) 
            {
                return ['success' => false, 'error_type' => 'auth', 'message' => 'Invalid username or password.'];
            }

            return ['success' => true, 'user' => $user];
        }

        public function getAccountsLive(): int
        {
            return $this -> userModel -> getAccountsLive();
        }
    }
?>