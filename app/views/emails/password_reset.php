<?php
    /** @var string|null $resetLink */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                padding: 20px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #111111; font-family: 'Helvetica Neue', Arial, sans-serif; color: #fbf5eb;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #111111; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" class="email-container" width="100%" cellspacing="0" cellpadding="0" style="max-width: 540px; width: 100%; background-color: #22232E; border: 1px solid #505050; border-radius: 10px; padding: 40px; box-sizing: border-box;">
                    <tr>
                        <td>
                            <div style="display: flex; align-items: baseline; margin-bottom: 24px;">
                                <span style="font-family: 'Helvetica Neue', Arial, sans-serif; font-weight: 500; font-size: 28px; line-height: 1; color: #fbf5eb;">iACADEMY</span><span style="font-family: 'Helvetica Neue', Arial, sans-serif; font-weight: 500; font-size: 28px; color: #6F91D0; line-height: 1;">.</span><span style="font-family: 'Playfair Display', Georgia, serif; font-style: italic; font-weight: 500; font-size: 30px; line-height: 1; color: #fbf5eb;">Confessions</span>
                            </div>

                            <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 24px; font-weight: 500; font-style: italic; margin: 0 0 12px 0; color: #fbf5eb;">Password Reset Request</h1>
                            <p style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 16px; line-height: 1.4; color: #9896a8; margin: 0 0 24px 0;">We received a request to reset your password. Click the button below to choose a new password for your account:</p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="<?= htmlspecialchars($resetLink) ?>" target="_blank" style="display: block; width: 100%; font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 15px; padding: 12px; border-radius: 10px; text-align: center; cursor: pointer; text-decoration: none; background-color: #22356D; border: 1px solid #6F91D0; color: #B8CEF6; box-sizing: border-box;">Reset Password</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 13px; color: #505050; line-height: 1.4; margin: 0 0 30px 0;">This secure link will expire in <strong>30 minutes</strong>. If you did not request a password reset, please ignore this email.</p>
                            <hr style="border: none; border-top: 1px solid #505050; margin: 30px 0;">
                            <p style="font-family: 'Helvetica Neue', Arial, sans-serif; text-align: center; font-size: 14px; color: #505050; margin: 0;">&copy; <?= date('Y') ?> iACADEMY Confessions. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>