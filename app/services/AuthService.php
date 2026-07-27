<?php
    class AuthService
    {
        private User $userModel;
        private PasswordReset $passwordResetModel;
        private Mailer $mailer;
        private array $mailConfig;

        public function __construct()
        {
            $this -> userModel = new User();
            $this -> passwordResetModel = new PasswordReset();
            $this -> mailer = new Mailer();
            $this -> mailConfig = Config::mail();
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

        public function forgotPassword(string $email): array
        {
            $email = trim($email);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                return ['success' => false, 'message' => 'Invalid email format.'];
            }

            $user = User::findByEmail($email);

            if (!$user) 
            {
                return ['success' => true, 'message' => 'If that email is registered, a reset link has been sent.'];
            }

            $token = bin2hex(random_bytes(32));

            $this -> passwordResetModel -> create($user -> getId(), $token, 1800);

            $resetLink = $this -> mailConfig['app_url'] . '?url=auth/reset&token=' . $token;
            $this -> mailer -> sendPasswordReset($user -> getEmail(), $resetLink);

            return ['success' => true, 'message' => 'If that email is registered, a reset link has been sent.'];
        }

        public function resetPassword(string $token, string $newPassword, string $confirmPassword): array
        {
            if ($token === '') 
            {
                return ['success' => false, 'message' => 'Invalid or missing reset token.'];
            }

            if ($newPassword === '' || $confirmPassword === '')
            {
                return ['success' => false, 'message' => 'Both password fields are required.'];
            }

            if ($newPassword !== $confirmPassword) 
            {
                return ['success' => false, 'message' => 'Passwords do not match.'];
            }

            if (strlen($newPassword) < 8) 
            {
                return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
            }

            $reset = $this -> passwordResetModel -> findValidByToken($token);

            if (!$reset) 
            {
                return ['success' => false, 'message' => 'This reset link is invalid or has expired.'];
            }

            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $this -> userModel -> updatePassword((int) $reset['user_id'], $hashed);
            $this -> passwordResetModel -> markUsed((int) $reset['id']);

            return ['success' => true, 'message' => 'Password updated successfully.'];
        }

        public function getAccountsLive(): int
        {
            return $this -> userModel -> getAccountsLive();
        }
    }
?>