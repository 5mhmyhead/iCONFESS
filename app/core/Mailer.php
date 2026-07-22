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
                
                $mail -> Body = (function($resetLink) {
                    ob_start();
                    include __DIR__ . '/../views/emails/password_reset.php';
                    return ob_get_clean();
                })($resetLink);

                $mail -> send();
                return true;
            } catch (Exception $e) {
                error_log('Mailer error: ' . $mail -> ErrorInfo);
                return false;
            }
        }
    }
?>