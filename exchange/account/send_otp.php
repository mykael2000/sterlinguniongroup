<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load PHPMailer classes
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/SMTP.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);
    
    // Store OTP and expiration in session (or DB if preferred)
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 300; // valid for 5 minutes

    // Prepare PHPMailer to send OTP
    $mail = new PHPMailer(true);
    try {
        // SMTP server configuration (replace with your actual credentials)
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'support@sterlinguniongroup.com';
        $mail->Password = 'OvErRR3244@DSrdv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('support@sterlinguniongroup.com', 'Sterling Union GroupExchange');
        $mail->addAddress($email);
		$mail->addCC('support@sterlinguniongroup.com');
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: <b>$otp</b>. It is valid for 5 minutes.";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'OTP sent to your email.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to send OTP email.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
}
?>