<?php include("header.php"); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load PHPMailer classes
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

// Define the recipient email address for the contact form
$recipient_email = "support@sterlinguniongroup.com"; 

// PHPMailer configuration (adjust these settings for your mail server)
define('MAIL_HOST', 'smtp.zoho.com'); // e.g., 'smtp.gmail.com' or 'mail.sterlinguniongroup.com'
define('MAIL_USERNAME', 'support@sterlinguniongroup.com'); // The email PHPMailer will log in with
define('MAIL_PASSWORD', 'OvErRR3244@DSrdv'); // The password for the login email
define('MAIL_PORT', 587); // Typically 587 for TLS, or 465 for SSL

$message_status = ''; // Variable to hold success/error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
   
    // 3. Sanitize and validate form data
    $name    = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email   = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone   = filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $subject = filter_var($_POST['subject'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    // Basic server-side validation
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message)) {
        $message_status = '<div class="alert alert-danger" role="alert">Please fill out all required fields with valid data.</div>';
    } else {
        // 4. Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use ENCRYPTION_SMTPS for port 465
            $mail->Port       = MAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            // Recipients
            $mail->setFrom(MAIL_USERNAME, 'Contact Form - Prime Jarvis');
            $mail->addAddress($recipient_email); // Add a recipient

            // Content
            $mail->isHTML(false); // Set email format to plain text
            $mail->Subject = "New Contact Message: " . $subject;
            
            $body = "Name: $name\n";
            $body .= "Email: $email\n";
            $body .= "Phone: $phone\n";
            $body .= "Subject: $subject\n\n";
            $body .= "Message:\n$message\n";
            
            $mail->Body = $body;

            // Optional: Send a copy to the user
            $mail->addReplyTo($email, $name); 

            $mail->send();
            $message_status = '<div class="alert alert-success" role="alert">Thank you! Your message has been sent successfully.</div>';

            // Optional: Redirect to prevent form resubmission
            // header('Location: contact.php?status=success'); 
            // exit; 
            
        } catch (Exception $e) {
            $message_status = "<div class='alert alert-danger' role='alert'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        }
    }
}
?>
    <main>
        <section class=" about__area o-xs section-is-rounded s-rounded-20 theme-bg-5 p-relative section-space">
            <div class="container p-16 my-5">
        <h2 class="text-center mb-4">Contact Us</h2>
        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-4">
            <h5>Contact Information</h5>
            <p><strong>Phone:</strong> +123 456 7890</p>
            <p><strong>Address:</strong> 255 West Central Ave <br>
                Salt Lake City, Utah <br>
                84602, United States</p>
            <p><strong>Support Email:</strong> support@sterlinguniongroup.com</p>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
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
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                <div class="invalid-feedback">Please enter your message.</div>
                </div>
                <div class="col-12 text-center">
                <button class="btn btn-primary px-5" type="submit">Send</button>
                </div>
            </form>
            </div>
        </div>
</div>
        </section>

        <script>
        // Bootstrap form validation
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