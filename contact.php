<?php include("header.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

$recipient_email = "support@sterlinguniongroup.com";

define('MAIL_HOST', 'smtp.zoho.com');
define('MAIL_USERNAME', 'support@sterlinguniongroup.com');
define('MAIL_PASSWORD', 'OvErRR3244@DSrdv');
define('MAIL_PORT', 587);

$message_status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email   = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone   = filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $subject = filter_var($_POST['subject'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message)) {
        $message_status = '<div class="alert alert-danger" role="alert">Please fill out all required fields with valid data.</div>';
    } else {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = MAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(MAIL_USERNAME, 'Contact Form - Prime Jarvis');
            $mail->addAddress($recipient_email);

            $mail->isHTML(false);
            $mail->Subject = "New Contact Message: " . $subject;

            $body = "Name: $name\n";
            $body .= "Email: $email\n";
            $body .= "Phone: $phone\n";
            $body .= "Subject: $subject\n\n";
            $body .= "Message:\n$message\n";

            $mail->Body = $body;
            $mail->addReplyTo($email, $name);

            $mail->send();
            $message_status = '<div class="alert alert-success" role="alert">Thank you! Your message has been sent successfully.</div>';
        } catch (Exception $e) {
            $message_status = "<div class='alert alert-danger' role='alert'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        }
    }
}
?>
<main>
    <section class="sip-section">
        <div class="container">
            <div class="sip-section-title">
                <span class="sip-badge">Contact Desk</span>
                <h2>Talk to our investment support team</h2>
                <p>Reach out for account onboarding, technical support, or general platform inquiries.</p>
            </div>

            <div class="sip-contact-wrap">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-4">
                        <div class="sip-card h-100">
                            <span class="sip-badge">Direct Channels</span>
                            <h3>Contact Information</h3>
                            <p class="mb-3">Phone: +123 456 7890</p>
                            <p class="mb-3">Address: 255 West Central Ave, Salt Lake City, Utah 84602, United States</p>
                            <p class="mb-0">Email: support@sterlinguniongroup.com</p>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="sip-card h-100">
                            <span class="sip-badge">Secure Form</span>
                            <h3>Send us a message</h3>
                            <?php echo $message_status; ?>
                            <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Please enter a valid email.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" pattern="[+]?[0-9\s\-]{7,15}">
                                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                    <div class="invalid-feedback">Subject is required.</div>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                    <div class="invalid-feedback">Please enter your message.</div>
                                </div>
                                <div class="col-12">
                                    <button class="bd-gradient-btn border-0" type="submit">Send Message <span><i class="fi fi-rr-angle-right"></i></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    </script>
</main>
<?php include("footer.php"); ?>