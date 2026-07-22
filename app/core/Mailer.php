<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mailer
    {
        private array $config;

        public function __construct()
        {
            $this -> config = require __DIR__ . '/../config/mail.php';
        }

        public function sendPasswordReset(string $toEmail, string $resetLink): bool
        {
            $mail = new PHPMailer(true);

            try {
                $mail -> isSMTP();
                $mail -> Host = $this -> config['host'];
                $mail -> SMTPAuth = true;
                $mail -> Username = $this -> config['username'];
                $mail -> Password = $this -> config['password'];
                $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail -> Port = $this -> config['port'];

                $mail -> setFrom($this -> config['from_email'], $this -> config['from_name']);
                $mail -> addAddress($toEmail);

                $mail -> isHTML(true);
                $mail -> Subject = 'Reset your iACADEMY Confessions password';
                $mail -> Body = '
                    <p>Someone requested a password reset for your account.</p>
                    <p><a href="' . htmlspecialchars($resetLink) . '">Click here to reset your password</a></p>
                    <p>This link expires in 30 minutes. If you didn\'t request this, you can ignore this email.</p>
                ';

                $mail -> send();
                return true;
            } catch (Exception $e) {
                error_log('Mailer error: ' . $mail -> ErrorInfo);
                return false;
            }
        }
    }
?>