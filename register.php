<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
include("exchange/account/connection.php");

require __DIR__ . '/aws/vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

$message = ""; // Initialize message variable

if(empty($_GET['ref_email'])){
  	$ref = "";
}else{
	$ref = $_GET['ref_email'];
}
if (isset($_POST['register'])) {
    // Sanitize and collect form inputs
    $firstname = trim($_POST["fname"]);
    $lastname = trim($_POST["lname"]);
   
    $email = trim($_POST["email"]);
   	$country = trim($_POST['country']);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);
    $confirmpassword = trim($_POST["confirmpassword"]);
    $ref_by = isset($_POST["ref_by"]) ? trim($_POST["ref_by"]) : null; // Handle optional referral ID

    $has_error = false; // Flag to track if any error occurred during validation

    // --- Validation Checks ---

    // 1. Check database connection
    if ($conn->connect_error) {
        $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>Database connection failed: " . $conn->connect_error . "</div>";
        $has_error = true;
    }

    // 2. Password Mismatch Check
    if (!$has_error && $password !== $confirmpassword) {
        $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>Passwords do not match. Please try again.</div>";
        $has_error = true;
    }

    // 3. Check if email already exists
    if (!$has_error) {
        $stmt_check_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
        // Check if prepare was successful
        if ($stmt_check_email === false) {
            $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>Database error (email check): " . $conn->error . "</div>";
            $has_error = true;
        } else {
            $stmt_check_email->bind_param("s", $email);
            $stmt_check_email->execute();
            $result_check_email = $stmt_check_email->get_result();
            if ($result_check_email->num_rows > 0) {
                $message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">The email has already been taken.</div>';
                $has_error = true;
            }
            $stmt_check_email->close();
        }
    }
    
    // You might want to add more validation here, e.g.,
    // - Check if username already exists
    // - Validate email format
    // - Validate password strength
    // - Validate phone number format

    // --- Proceed to Registration Only if No Errors ---
    if (!$has_error) {
        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare and execute the INSERT statement
        $stmt_insert_user = $conn->prepare("INSERT INTO users (firstname, lastname, email, phone, country, password, referred_by_email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Check if prepare was successful
        if ($stmt_insert_user === false) {
            $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>Database error (user insertion): " . $conn->error . "</div>";
        } else {
            // Include ref_by in binding
            $stmt_insert_user->bind_param("sssssss", $firstname, $lastname, $email, $phone, $country, $password, $ref_by);

            if ($stmt_insert_user->execute()) {
                // User successfully inserted into DB
                // Attempt to send email
                try {
                        $awsAccessKeyId = getenv('AWS_ACCESS_KEY_ID');
                        $awsSecretAccessKey = getenv('AWS_SECRET_ACCESS_KEY');
                        $awsRegion = getenv('AWS_DEFAULT_REGION') ?: 'us-east-1';

                        if (empty($awsAccessKeyId) || empty($awsSecretAccessKey)) {
                            throw new Exception('AWS SES credentials are not configured.');
                        }

                        // Send via AWS SES
                        $SesClient = new SesClient([
                            'version'     => 'latest',
                            'region'      => $awsRegion,
                            'credentials' => [
                                'key'    => $awsAccessKeyId,
                                'secret' => $awsSecretAccessKey,
                            ],
                        ]);
                        $htmlBody = "<html>
                    <head></head>
                    <body style='background-color: #1e2024; padding: 45px;'>
                        <div>
                            <img style='position:relative; left:35%; border-radius: 50%; height: 100px; width: 100px;' src='https://sterlinguniongroup.com/logo.jpg'>
                            <h3 style='color: black;'>Mail From noreply@sterlinguniongroup.com - Successful Registration</h3>
                        </div>
                        <div style='color: #fff;'>
                            <h3>Dear $firstname,</h3>
                            <p>Welcome to Prime Jarvis, an automated trading platform where even investors with zero experience can make profits.</p>
                            <h5>Click the button below to log in and proceed to get the best experience from Prime Jarvis</h5>
                            <a style='background-color:#060c39;color:#fff; padding:15px; text-decoration:none;border-radius: 10px;font-size: 20px;'
                            href='https://sterlinguniongroup.com/login.php'>Sign in</a>
                            <h5>Note: Do not disclose the details in this email to anyone.</h5>
                        </div>
                        <div style='background-color: white; color: black;'>
                            <h3 style='color: black;'>Support@sterlinguniongroup.com</h3>
                        </div>
                    </body>
                    </html>";

                        $result = $SesClient->sendEmail([
                            'Source' => 'noreply@sterlinguniongroup.com', // must be verified in SES
                            'Destination' => [
                                'ToAddresses' => [$email],
                            ],
                            'Message' => [
                                'Subject' => ['Data' => 'You Have Succesfully Registered At SterlingUnionGroup - The Journey Begins'],
                                'Body' => [
                                    'Html' => ['Data' => $htmlBody],
                                ],
                            ],
                        ]);

                        $message = "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative' role='alert'>
                    Account Created Successfully! Please check your email for more details.</div>";
                    header("refresh: 2;url=login.php"); // Redirect after successful registration and email attempt
                   

                    } catch (AwsException $e) {
                        echo "Message could not be sent. AWS SES Error: " . $e->getAwsErrorMessage();
                    }
                    
            } else {
                // Error during database INSERT operation (e.g., if username was unique and duplicate, or other DB constraints)
                $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>Error: " . $stmt_insert_user->error . "</div>";
            }
            $stmt_insert_user->close();
        }
    }
}

// Close the database connection after all operations are done
if (isset($conn)) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Prime Jarvis</title>
    <!-- Inter Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(45, 55, 72, 0.3) 1px, transparent 1px);
            background-size: 20px 20px;
        }
  	.alert {
  padding: 1rem;
  border: 1px solid transparent;
  border-radius: 0.5rem;
  position: relative;
}

/*
 * Specific styling for a "danger" or error alert.
 * This class applies a red-themed color palette to indicate an error or warning.
 */
.alert-danger {
  color: #721c24;
  background-color: #f8d7da;
  border-color: #f5c6cb;
}

/*
 * Utility class for margin.
 * 'my-3' stands for margin-top and margin-bottom, with '3' representing a standard spacing value.
 */
.my-3 {
  margin-top: 1rem;
  margin-bottom: 1rem;
}
    </style>
</head>
<body class="bg-[#111111] text-white flex items-center justify-center min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-grid-pattern">
    <div class="max-w-4xl w-full flex flex-col md:flex-row rounded-2xl overflow-hidden shadow-2xl bg-[#111111] border border-gray-800">

        <!-- Left Column - Visuals and Marketing -->
        <div class="hidden md:flex flex-1 p-8 lg:p-12 flex-col justify-between bg-[#111111] relative">
            <div class="absolute inset-0 z-0 opacity-20">
                <canvas id="chartCanvas" class="w-full h-full"></canvas>
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="text-indigo-400 text-3xl font-extrabold tracking-tight">
                    <img src="sterlinglogo.png">
                </div>
                <div class="mt-auto">
                    <h1 class="text-4xl font-bold leading-tight mt-8">
                        Join the <br>Future of <span class="text-transparent bg-clip-text bg-[#380bdb]">Crypto Trading</span>
                    </h1>
                    <p class="mt-4 text-gray-300 max-w-sm">
                        Seamlessly register in minutes and gain access to a world-class platform with advanced tools and real-time market data.
                    </p>
                    <ul class="mt-8 space-y-4 text-gray-400">
                        <li class="flex items-center">
                            <i class="fa-solid fa-chart-line text-[#380bdb] w-5 h-5 mr-3"></i>
                            <span class="text-gray-200">Live Market Insights</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fa-solid fa-lock text-[#380bdb] w-5 h-5 mr-3"></i>
                            <span class="text-gray-200">Secure & Protected</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fa-solid fa-headset text-[#380bdb] w-5 h-5 mr-3"></i>
                            <span class="text-gray-200">24/7 Support</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column - Registration Form -->
        <div class="bg-[#111111] flex-1 p-6 sm:p-10 lg:p-16 flex items-center justify-center">
            <div class="w-full max-w-md">
                <h2 class="text-3xl font-bold text-center text-gray-100">Create Your Account</h2>
                <p class="mt-2 text-center text-sm text-gray-400">
                    Have An Account?
                    <a href="login.php" class="font-medium text-[#380bdb] hover:text-[#1c0373] transition-colors duration-200">
                        Log in
                    </a>
                </p>

                <form action="" method="post" class="mt-8 space-y-6">
                    <?php echo $message; ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="fname" class="sr-only">First Name</label>
                            <input id="fname" name="fname" type="text" autocomplete="given-name" required class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="First Name">
                        </div>
                        <div>
                            <label for="lname" class="sr-only">Last Name</label>
                            <input id="lname" name="lname" type="text" autocomplete="family-name" required class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="Last Name">
                        </div>
                    </div>

                    

                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="Email Address">
                    </div>

                    <div>
                        <label for="phone" class="sr-only">Phone Number</label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" required class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="Phone Number">
                    </div>
					<div>
                        <label for="country" class="sr-only">Country</label>
                        <select id="country" name="country" required
                          class="block w-full px-4 py-3 border border-gray-700 rounded-xl bg-[#111111] text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                          <option value="">Select a country</option>
                          <option value="Afghanistan">Afghanistan</option>
                          <option value="Albania">Albania</option>
                          <option value="Algeria">Algeria</option>
                          <option value="American Samoa">American Samoa</option>
                          <option value="Andorra">Andorra</option>
                          <option value="Angola">Angola</option>
                          <option value="Anguilla">Anguilla</option>
                          <option value="Antarctica">Antarctica</option>
                          <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                          <option value="Argentina">Argentina</option>
                          <option value="Armenia">Armenia</option>
                          <option value="Aruba">Aruba</option>
                          <option value="Australia">Australia</option>
                          <option value="Austria">Austria</option>
                          <option value="Azerbaijan">Azerbaijan</option>
                          <option value="Bahamas">Bahamas</option>
                          <option value="Bahrain">Bahrain</option>
                          <option value="Bangladesh">Bangladesh</option>
                          <option value="Barbados">Barbados</option>
                          <option value="Belarus">Belarus</option>
                          <option value="Belgium">Belgium</option>
                          <option value="Belize">Belize</option>
                          <option value="Benin">Benin</option>
                          <option value="Bermuda">Bermuda</option>
                          <option value="Bhutan">Bhutan</option>
                          <option value="Bolivia">Bolivia</option>
                          <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                          <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                          <option value="Botswana">Botswana</option>
                          <option value="Brazil">Brazil</option>
                          <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                          <option value="Brunei Darussalam">Brunei Darussalam</option>
                          <option value="Bulgaria">Bulgaria</option>
                          <option value="Burkina Faso">Burkina Faso</option>
                          <option value="Burundi">Burundi</option>
                          <option value="Cabo Verde">Cabo Verde</option>
                          <option value="Cambodia">Cambodia</option>
                          <option value="Cameroon">Cameroon</option>
                          <option value="Canada">Canada</option>
                          <option value="Cayman Islands">Cayman Islands</option>
                          <option value="Central African Republic">Central African Republic</option>
                          <option value="Chad">Chad</option>
                          <option value="Chile">Chile</option>
                          <option value="China">China</option>
                          <option value="Christmas Island">Christmas Island</option>
                          <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                          <option value="Colombia">Colombia</option>
                          <option value="Comoros">Comoros</option>
                          <option value="Congo">Congo</option>
                          <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
                          <option value="Cook Islands">Cook Islands</option>
                          <option value="Costa Rica">Costa Rica</option>
                          <option value="Côte d’Ivoire">Côte d’Ivoire</option>
                          <option value="Croatia">Croatia</option>
                          <option value="Cuba">Cuba</option>
                          <option value="Curaçao">Curaçao</option>
                          <option value="Cyprus">Cyprus</option>
                          <option value="Czech Republic">Czech Republic</option>
                          <option value="Denmark">Denmark</option>
                          <option value="Djibouti">Djibouti</option>
                          <option value="Dominica">Dominica</option>
                          <option value="Dominican Republic">Dominican Republic</option>
                          <option value="Ecuador">Ecuador</option>
                          <option value="Egypt">Egypt</option>
                          <option value="El Salvador">El Salvador</option>
                          <option value="Equatorial Guinea">Equatorial Guinea</option>
                          <option value="Eritrea">Eritrea</option>
                          <option value="Estonia">Estonia</option>
                          <option value="Eswatini">Eswatini</option>
                          <option value="Ethiopia">Ethiopia</option>
                          <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                          <option value="Faroe Islands">Faroe Islands</option>
                          <option value="Fiji">Fiji</option>
                          <option value="Finland">Finland</option>
                          <option value="France">France</option>
                          <option value="French Guiana">French Guiana</option>
                          <option value="French Polynesia">French Polynesia</option>
                          <option value="French Southern Territories">French Southern Territories</option>
                          <option value="Gabon">Gabon</option>
                          <option value="Gambia">Gambia</option>
                          <option value="Georgia">Georgia</option>
                          <option value="Germany">Germany</option>
                          <option value="Ghana">Ghana</option>
                          <option value="Gibraltar">Gibraltar</option>
                          <option value="Greece">Greece</option>
                          <option value="Greenland">Greenland</option>
                          <option value="Grenada">Grenada</option>
                          <option value="Guadeloupe">Guadeloupe</option>
                          <option value="Guam">Guam</option>
                          <option value="Guatemala">Guatemala</option>
                          <option value="Guernsey">Guernsey</option>
                          <option value="Guinea">Guinea</option>
                          <option value="Guinea-Bissau">Guinea-Bissau</option>
                          <option value="Guyana">Guyana</option>
                          <option value="Haiti">Haiti</option>
                          <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                          <option value="Holy See">Holy See</option>
                          <option value="Honduras">Honduras</option>
                          <option value="Hong Kong">Hong Kong</option>
                          <option value="Hungary">Hungary</option>
                          <option value="Iceland">Iceland</option>
                          <option value="India">India</option>
                          <option value="Indonesia">Indonesia</option>
                          <option value="Iran">Iran</option>
                          <option value="Iraq">Iraq</option>
                          <option value="Ireland">Ireland</option>
                          <option value="Isle of Man">Isle of Man</option>
                          <option value="Israel">Israel</option>
                          <option value="Italy">Italy</option>
                          <option value="Jamaica">Jamaica</option>
                          <option value="Japan">Japan</option>
                          <option value="Jersey">Jersey</option>
                          <option value="Jordan">Jordan</option>
                          <option value="Kazakhstan">Kazakhstan</option>
                          <option value="Kenya">Kenya</option>
                          <option value="Kiribati">Kiribati</option>
                          <option value="Korea, North">Korea, North</option>
                          <option value="Korea, South">Korea, South</option>
                          <option value="Kuwait">Kuwait</option>
                          <option value="Kyrgyzstan">Kyrgyzstan</option>
                          <option value="Laos">Laos</option>
                          <option value="Latvia">Latvia</option>
                          <option value="Lebanon">Lebanon</option>
                          <option value="Lesotho">Lesotho</option>
                          <option value="Liberia">Liberia</option>
                          <option value="Libya">Libya</option>
                          <option value="Liechtenstein">Liechtenstein</option>
                          <option value="Lithuania">Lithuania</option>
                          <option value="Luxembourg">Luxembourg</option>
                          <option value="Macao">Macao</option>
                          <option value="Madagascar">Madagascar</option>
                          <option value="Malawi">Malawi</option>
                          <option value="Malaysia">Malaysia</option>
                          <option value="Maldives">Maldives</option>
                          <option value="Mali">Mali</option>
                          <option value="Malta">Malta</option>
                          <option value="Marshall Islands">Marshall Islands</option>
                          <option value="Martinique">Martinique</option>
                          <option value="Mauritania">Mauritania</option>
                          <option value="Mauritius">Mauritius</option>
                          <option value="Mayotte">Mayotte</option>
                          <option value="Mexico">Mexico</option>
                          <option value="Micronesia">Micronesia</option>
                          <option value="Moldova">Moldova</option>
                          <option value="Monaco">Monaco</option>
                          <option value="Mongolia">Mongolia</option>
                          <option value="Montenegro">Montenegro</option>
                          <option value="Montserrat">Montserrat</option>
                          <option value="Morocco">Morocco</option>
                          <option value="Mozambique">Mozambique</option>
                          <option value="Myanmar">Myanmar</option>
                          <option value="Namibia">Namibia</option>
                          <option value="Nauru">Nauru</option>
                          <option value="Nepal">Nepal</option>
                          <option value="Netherlands">Netherlands</option>
                          <option value="New Caledonia">New Caledonia</option>
                          <option value="New Zealand">New Zealand</option>
                          <option value="Nicaragua">Nicaragua</option>
                          <option value="Niger">Niger</option>
                          <option value="Nigeria">Nigeria</option>
                          <option value="Niue">Niue</option>
                          <option value="Norfolk Island">Norfolk Island</option>
                          <option value="North Macedonia">North Macedonia</option>
                          <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                          <option value="Norway">Norway</option>
                          <option value="Oman">Oman</option>
                          <option value="Pakistan">Pakistan</option>
                          <option value="Palau">Palau</option>
                          <option value="Palestine, State of">Palestine, State of</option>
                          <option value="Panama">Panama</option>
                          <option value="Papua New Guinea">Papua New Guinea</option>
                          <option value="Paraguay">Paraguay</option>
                          <option value="Peru">Peru</option>
                          <option value="Philippines">Philippines</option>
                          <option value="Pitcairn">Pitcairn</option>
                          <option value="Poland">Poland</option>
                          <option value="Portugal">Portugal</option>
                          <option value="Puerto Rico">Puerto Rico</option>
                          <option value="Qatar">Qatar</option>
                          <option value="Réunion">Réunion</option>
                          <option value="Romania">Romania</option>
                          <option value="Russian Federation">Russian Federation</option>
                          <option value="Rwanda">Rwanda</option>
                          <option value="Saint Barthlemy">Saint Barthélemy</option>
                          <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
                          <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                          <option value="Saint Lucia">Saint Lucia</option>
                          <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                          <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                          <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                          <option value="Samoa">Samoa</option>
                          <option value="San Marino">San Marino</option>
                          <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                          <option value="Saudi Arabia">Saudi Arabia</option>
                          <option value="Senegal">Senegal</option>
                          <option value="Serbia">Serbia</option>
                          <option value="Seychelles">Seychelles</option>
                          <option value="Sierra Leone">Sierra Leone</option>
                          <option value="Singapore">Singapore</option>
                          <option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
                          <option value="Slovakia">Slovakia</option>
                          <option value="Slovenia">Slovenia</option>
                          <option value="Solomon Islands">Solomon Islands</option>
                          <option value="Somalia">Somalia</option>
                          <option value="South Africa">South Africa</option>
                          <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                          <option value="South Sudan">South Sudan</option>
                          <option value="Spain">Spain</option>
                          <option value="Sri Lanka">Sri Lanka</option>
                          <option value="Sudan">Sudan</option>
                          <option value="Suriname">Suriname</option>
                          <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                          <option value="Sweden">Sweden</option>
                          <option value="Switzerland">Switzerland</option>
                          <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                          <option value="Taiwan">Taiwan</option>
                          <option value="Tajikistan">Tajikistan</option>
                          <option value="Tanzania">Tanzania</option>
                          <option value="Thailand">Thailand</option>
                          <option value="Timor-Leste">Timor-Leste</option>
                          <option value="Togo">Togo</option>
                          <option value="Tokelau">Tokelau</option>
                          <option value="Tonga">Tonga</option>
                          <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                          <option value="Tunisia">Tunisia</option>
                          <option value="Turkey">Turkey</option>
                          <option value="Turkmenistan">Turkmenistan</option>
                          <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                          <option value="Tuvalu">Tuvalu</option>
                          <option value="Uganda">Uganda</option>
                          <option value="Ukraine">Ukraine</option>
                          <option value="United Arab Emirates">United Arab Emirates</option>
                          <option value="United Kingdom">United Kingdom</option>
                          <option value="United States">United States</option>
                          <option value="Uruguay">Uruguay</option>
                          <option value="Uzbekistan">Uzbekistan</option>
                          <option value="Vanuatu">Vanuatu</option>
                          <option value="Venezuela">Venezuela</option>
                          <option value="Viet Nam">Viet Nam</option>
                          <option value="Wallis and Futuna">Wallis and Futuna</option>
                          <option value="Western Sahara">Western Sahara</option>
                          <option value="Yemen">Yemen</option>
                          <option value="Zambia">Zambia</option>
                          <option value="Zimbabwe">Zimbabwe</option>
                        </select>
                      </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="new-password" required class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="Password">
                        </div>
                        <div>
                            <label for="confirm-password" class="sr-only">Confirm Password</label>
                            <input id="confirm-password" name="confirmpassword" type="password" autocomplete="new-password" required class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div>
                        <label for="ref_by" class="sr-only">Referral ID</label>
                        <input id="ref_by" name="ref_by" value="<?php echo $ref; ?>" type="text" class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="Referral ID (optional)">
                    </div>

                    <div>
                        <button name="register" type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-[#1c0373] hover:from-indigo-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simple canvas animation for the background chart effect
        const chartCanvas = document.getElementById('chartCanvas');
        const ctx = chartCanvas.getContext('2d');
        let points = [];
        let animationFrameId;

        function resizeCanvas() {
            chartCanvas.width = chartCanvas.offsetWidth;
            chartCanvas.height = chartCanvas.offsetHeight;
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        function initPoints() {
            points = [];
            const numPoints = Math.floor(chartCanvas.width / 10);
            for (let i = 0; i <= numPoints; i++) {
                points.push({
                    x: i * (chartCanvas.width / numPoints),
                    y: Math.random() * chartCanvas.height,
                    speed: 0.1 + Math.random() * 0.2
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
            ctx.strokeStyle = '#818cf8';
            ctx.lineWidth = 1.5;
            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);

            for (let i = 0; i < points.length; i++) {
                points[i].y += Math.sin(Date.now() * 0.0005 + points[i].x * 0.01) * points[i].speed;
                ctx.lineTo(points[i].x, points[i].y);
            }
            ctx.stroke();

            // Draw a gradient fill below the line
            const gradient = ctx.createLinearGradient(0, 0, 0, chartCanvas.height);
            gradient.addColorStop(0, 'rgba(129, 140, 248, 0.4)');
            gradient.addColorStop(0.5, 'rgba(129, 140, 248, 0.1)');
            gradient.addColorStop(1, 'rgba(129, 140, 248, 0)');
            ctx.fillStyle = gradient;
            ctx.lineTo(chartCanvas.width, chartCanvas.height);
            ctx.lineTo(0, chartCanvas.height);
            ctx.closePath();
            ctx.fill();

            animationFrameId = requestAnimationFrame(draw);
        }

        window.onload = function() {
            initPoints();
            draw();
        };

      
    </script>
</body>
</html>
