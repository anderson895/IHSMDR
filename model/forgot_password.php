<?php
require_once '../includes/config.php'; // Your database configuration
require_once '../controller/forgot pass.php'; // Your custom functions
require '../phpmailer/autoload.php'; // Autoload PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['forgotPasswordEmail']);
    
    $forgot = new ForgotPassClass($conn);
    $token = $forgot->forgotPassword($email);

    if ($token) {
        // Generate the reset link with the token
        $resetLink = "http://localhost/panalo/change_password.php?token=" . urlencode($token);

        // Send the reset link via email
        if (sendResetLinkEmail($email, $resetLink)) {
            echo json_encode(['success' => true, 'message' => 'Please check your email for the password reset link.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send the email. Please try again later.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Email address not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

function sendResetLinkEmail($email, $resetLink) {
    $mail = new PHPMailer(true);
    try {
        // Set up SMTP (same as before)
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@seniorconnectofficial.com';
        $mail->Password = '83#96A^kU';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email content
        $mail->setFrom('info@seniorconnectofficial.com', 'Panalo Kay Haresco');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        
        // New HTML email template
        $mail->Body = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Password Reset</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .container {
                    background-color: #f8f9fa;
                    border-radius: 5px;
                    padding: 30px;
                }
                .logo {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .logo img {
                    max-width: 200px;
                }
                h1 {
                    color: #007bff;
                    text-align: center;
                }
                .button {
                    display: inline-block;
                    background-color: #007bff;
                    color: #ffffff;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    margin-top: 20px;
                }
                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 12px;
                    color: #666666;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='logo'>
                    <img src='https://panalocenter.com/assets/img/logo/Panalo%20Logo.png' alt='Panalo Kay Haresco Logo'>
                </div>
                <h1>Password Reset Request</h1>
                <p>Dear User,</p>
                <p>We received a request to reset your password for your Panalo Kay Haresco account. If you didn't make this request, you can safely ignore this email.</p>
                <p>To reset your password, please click the button below:</p>
                <p style='text-align: center;'>
                    <a href='{$resetLink}' class='button'>Reset Password</a>
                </p>
                <p>If the button above doesn't work, you can also copy and paste the following link into your browser:</p>
                <p>{$resetLink}</p>
                <p>This link will expire in 5 minutes for security reasons.</p>
                <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
                <p>Best regards,<br>The Panalo Kay Haresco Team</p>
            </div>
            <div class='footer'>
                <p>This email was sent to {$email}. If you didn't request a password reset, please ignore this email or contact us if you have concerns.</p>
                <p>&copy; 2024 Panalo Kay Haresco. All rights reserved.</p>
            </div>
        </body>
        </html>
        ";

        // Plain text version for email clients that don't support HTML
        $mail->AltBody = "
        Dear User,

        We received a request to reset your password for your Panalo Kay Haresco account. If you didn't make this request, you can safely ignore this email.

        To reset your password, please copy and paste the following link into your browser:
        {$resetLink}

        This link will expire in 5 minutes for security reasons.

        If you have any questions or need assistance, please don't hesitate to contact our support team.

        Best regards,
        The Panalo Kay Haresco Party List
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}
