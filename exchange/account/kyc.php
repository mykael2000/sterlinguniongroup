<?php
// --- FILE: kyc.php ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Core Includes
include('connection.php');
include('function.php');

 
$kyc_message = ''; 
$kyc_status = 'Not Submitted'; // Default status

// --- Fetch User's Current KYC Status ---
if ($user_id) {
    // Assuming $conn is your database connection object (mysqli)
    $status_sql = "SELECT kyc_status FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($status_sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $kyc_status = $row['kyc_status'] ?? 'Not Submitted';
        }
        $stmt->close();
    }
}

// Variables to control form state
$is_form_disabled = (strtolower($kyc_status) === 'verified' || strtolower($kyc_status) === 'pending');
$form_disabled_attr = $is_form_disabled ? 'disabled' : ''; // Used for HTML button

// --- KYC File Upload Configuration ---
$upload_dir = 'uploads/kyc_documents/'; 
$allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];
$max_file_size = 5 * 1024 * 1024; // 5MB

if (!is_dir($upload_dir)) {
    if (!@mkdir($upload_dir, 0755, true)) {
        $kyc_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Server Error: Cannot create upload directory. Check permissions.</div>';
    }
}

// --- PHP Submission Logic ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kyc_submit']) && !$is_form_disabled) {
    // ... (Your previous form data collection and file checking logic) ...
    $document_type = $_POST['document_type'] ?? '';
    $document_number = $_POST['document_number'] ?? '';
    
    $front_file = $_FILES['front_image'] ?? null;
    $back_file = $_FILES['back_image'] ?? null;
    
    // 1. Basic Validation
    if (empty($document_type) || empty($document_number) || $front_file['error'] !== UPLOAD_ERR_OK) {
        $kyc_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: Please fill in all required fields and upload the front image.</div>';
    } else {
        $file_uploads = [];
        $has_error = false;

        // 2. Process Front Image (Required)
        // ... (File processing and move_uploaded_file() logic as before) ...
        $front_ext = strtolower(pathinfo($front_file['name'], PATHINFO_EXTENSION));
        if (!in_array($front_ext, $allowed_types) || $front_file['size'] > $max_file_size) {
            $kyc_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: Invalid front file type or size (max 5MB, accepted: JPG, PNG, PDF).</div>';
            $has_error = true;
        } else {
            $front_filename = $user_id . '-' . strtolower($document_type) . '-front-' . time() . '.' . $front_ext;
            $front_target_path = $upload_dir . $front_filename;
            if (!move_uploaded_file($front_file['tmp_name'], $front_target_path)) {
                $kyc_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error uploading front file. Server write permission issue.</div>';
                $has_error = true;
            } else {
                $file_uploads['front'] = $front_target_path;
            }
        }
        
        // 3. Process Back Image (Optional)
        $back_path = null;
        if (!$has_error && $back_file && $back_file['error'] === UPLOAD_ERR_OK) {
             // ... (Back file processing logic as before) ...
            $back_ext = strtolower(pathinfo($back_file['name'], PATHINFO_EXTENSION));
            if (!in_array($back_ext, $allowed_types) || $back_file['size'] > $max_file_size) {
                $kyc_message = '<div class="bg-yellow-500 p-3 rounded text-white mb-4">Warning: Back image file is too large or invalid format. Skipping back image upload.</div>';
            } else {
                $back_filename = $user_id . '-' . strtolower($document_type) . '-back-' . time() . '.' . $back_ext;
                $back_target_path = $upload_dir . $back_filename;
                if (move_uploaded_file($back_file['tmp_name'], $back_target_path)) {
                    $back_path = $back_target_path;
                }
            }
        }

        // 4. Database Insertion & Status Update
        if (!$has_error) {
            $front_path = $file_uploads['front'];
            
            // CRITICAL: We update the status in the USERS table to 'Pending' immediately
            // to prevent multiple submissions while the admin is reviewing.
            $update_status_sql = "UPDATE users SET kyc_status = 'Pending' WHERE id = ?";
            $update_stmt = $conn->prepare($update_status_sql);
            $update_stmt->bind_param("i", $user_id);
            $update_stmt->execute();
            $update_stmt->close();

            // Insert the new submission details into the kyc_submissions table for admin review
            $sql = "INSERT INTO kyc_submissions (user_id, email, document_type, document_number, front_image_path, back_image_path, status, submitted_at)
                    VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("isssss", $user_id, $user_email, $document_type, $document_number, $front_path, $back_path);

                if ($stmt->execute()) {
                    $kyc_message = '<div class="bg-green-500 p-3 rounded text-white mb-4">Success! Your KYC documents have been submitted for review. Your status is now PENDING.</div>';
                    $kyc_status = 'Pending'; // Update local status variable
                    $is_form_disabled = true; // Disable form immediately
                    $form_disabled_attr = 'disabled';
                } else {
                    $kyc_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Database Error: Could not save KYC submission.</div>';
                }
                $stmt->close();
            } else {
                $kyc_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">System Error: SQL preparation failed.</div>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sterling Union GroupDashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0c0e11;
            color: #d1d5db;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-[#121417] text-gray-300">
    <div class="min-h-screen flex flex-col">
        <?php 
        // Assuming topnav.php contains your header/navigation structure
        include('topnav.php'); 
        ?>

        <main class="flex-1 p-4 overflow-y-auto no-scrollbar">
            <div id="kyc-content" class="max-w-xl mx-auto">
                <div class="mb-6">
                    <h1 class="text-xl font-bold mb-1 text-white">Identity Verification (KYC)</h1>
                    <p class="text-sm text-gray-400">Please upload clear copies of your government-issued ID to verify your account.</p>
                </div>
                
                <?php echo $kyc_message; ?>

                <?php 
                $status_color = match(strtolower($kyc_status)) {
                    'verified' => 'bg-green-600',
                    'pending' => 'bg-yellow-600',
                    'rejected' => 'bg-red-600',
                    default => 'bg-gray-600',
                };
                ?>
                <div class="p-3 mb-6 rounded-lg <?php echo $status_color; ?> text-white font-semibold flex justify-between items-center">
                    <span>Current Status: <?php echo htmlspecialchars(ucfirst($kyc_status)); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <?php if (strtolower($kyc_status) === 'verified'): ?>
                    <div class="bg-green-500/20 text-green-300 border border-green-500 p-4 rounded-lg mb-6 text-center font-semibold">
                        ✅ Your account is fully verified. No further action is required.
                    </div>
                <?php elseif (strtolower($kyc_status) === 'pending'): ?>
                    <div class="bg-yellow-500/20 text-yellow-300 border border-yellow-500 p-4 rounded-lg mb-6 text-center font-semibold">
                        ⏳ Your documents are currently under review. Please check back later.
                    </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="kyc_submit" value="1">
                    
                    <div class="bg-[#1f2125] rounded-lg p-6 space-y-6">
                        
                        <div>
                            <label for="document-type" class="block text-sm font-medium text-gray-400 mb-2">Document Type</label>
                            <select id="document-type" name="document_type" required <?php echo $form_disabled_attr; ?>
                                class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none disabled:opacity-75 disabled:cursor-not-allowed">
                                <option value="" disabled selected>Select an ID type</option>
                                <option value="Passport">Passport</option>
                                <option value="DriverLicense">Driver's License</option>
                                <option value="NationalID">National ID Card</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="document-number" class="block text-sm font-medium text-gray-400 mb-2">Document Number</label>
                            <input type="text" id="document-number" name="document_number" required <?php echo $form_disabled_attr; ?>
                                placeholder="Enter the document ID number" 
                                class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none disabled:opacity-75 disabled:cursor-not-allowed">
                        </div>

                        <div class="space-y-4 pt-2 border-t border-gray-700/50">
                            <p class="text-sm font-semibold text-white">Upload Documents (Max 5MB per file, JPG, PNG, PDF)</p>
                            
                            <div>
                                <label for="front-image" class="block text-sm font-medium text-gray-400 mb-2">
                                    <span class="text-lg text-red-500">*</span> Front Image / Main Page
                                </label>
                                <input type="file" id="front-image" name="front_image" required accept="image/jpeg,image/png,application/pdf" <?php echo $form_disabled_attr; ?>
                                    class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 
                                           file:text-sm file:font-semibold file:bg-green-500 file:text-white hover:file:bg-green-600 disabled:file:bg-gray-500 disabled:file:text-gray-300">
                                <p class="text-xs text-gray-500 mt-1">Required: Passport bio page, front of license, or front of ID card.</p>
                            </div>

                            <div>
                                <label for="back-image" class="block text-sm font-medium text-gray-400 mb-2">
                                    Back Image (Required for ID Cards/Licenses)
                                </label>
                                <input type="file" id="back-image" name="back_image" accept="image/jpeg,image/png,application/pdf" <?php echo $form_disabled_attr; ?>
                                    class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 
                                           file:text-sm file:font-semibold file:bg-gray-700 file:text-white hover:file:bg-gray-600 disabled:file:bg-gray-500 disabled:file:text-gray-300">
                                <p class="text-xs text-gray-500 mt-1">Optional for passports, required for two-sided IDs/licenses.</p>
                            </div>
                        </div>

                        <button type="submit" <?php echo $form_disabled_attr; ?>
                            class="w-full bg-green-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-[#1f2125] disabled:bg-gray-700 disabled:text-gray-400 disabled:cursor-not-allowed">
                            <?php 
                            if (strtolower($kyc_status) === 'verified') {
                                echo 'Verification Completed';
                            } elseif (strtolower($kyc_status) === 'pending') {
                                echo 'Submission Under Review';
                            } else {
                                echo 'Submit for Verification';
                            }
                            ?>
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <?php 
        include('navbar.php'); 
        ?>
    </div>
  <script src="js/topNavFooter.js"></script>
</body>
</html>