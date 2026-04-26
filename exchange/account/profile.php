<?php
include('connection.php'); // Assumed $conn (mysqli connection) is available
include('function.php'); // Assumed this populates the $user array

// --- CRITICAL: Ensure $user is set and all keys are strings to prevent PHP Deprecated warnings ---
$user = array_merge([
    'id'        => 'N/A', 
    'firstname' => '', 
    'lastname'  => '', 
    'email'     => '', 
    'phone'     => '', 
    'address'   => '', 
    'country'   => '',
    // Assuming your user data includes the hashed password for verification
    'password'  => '' 
], $user ?? []); 

$update_message = '';
$password_message = ''; // New variable for password change messages

// -----------------------------------------------------------
// 1. Handle Profile Update Request (General Settings)
// -----------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    
    // ... (Existing Profile Update Logic remains here) ...
    if (!isset($user['id']) || $user['id'] === 'N/A') {
        $update_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: User session is invalid. Cannot update profile.</div>';
    } else {
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $country = $_POST['country'] ?? '';
        $user_id = $user['id']; 

        if (empty($firstname) || empty($lastname)) {
            $update_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: First name and Last name are required.</div>';
        } else {
            // Prepare the SQL statement for updating user profile
            $sql = "UPDATE users SET 
                    firstname = ?, 
                    lastname = ?, 
                    phone = ?, 
                    address = ?, 
                    country = ? 
                    WHERE id = ?";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssssi", $firstname, $lastname, $phone, $address, $country, $user_id);
                
                if ($stmt->execute()) {
                    $update_message = '<div class="bg-green-500 p-3 rounded text-white mb-4">Profile updated successfully!</div>';
                    
                    // Update the global $user array
                    $user['firstname'] = $firstname;
                    $user['lastname'] = $lastname;
                    $user['phone'] = $phone;
                    $user['address'] = $address;
                    $user['country'] = $country;
                    
                } else {
                    $update_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Database Error: Could not update profile.</div>';
                }
                $stmt->close();
            } else {
                $update_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">System Error: SQL statement preparation failed.</div>';
            }
        }
    }
}

// -----------------------------------------------------------
// 2. Handle Password Change Request (Security Section)
// -----------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $user_id = $user['id']; 
    $hashed_password = $user['password']; // Hashed password from the database/session

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $password_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">All password fields are required.</div>';
    } elseif ($new_password !== $confirm_password) {
        $password_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">New password and confirmation do not match.</div>';
    } elseif (strlen($new_password) < 8) { // Minimum length check
        $password_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">New password must be at least 8 characters long.</div>';
    } elseif ($current_password !== $user['password']) {
        // CRITICAL: Verify the current password against the stored hash
        $password_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Incorrect current password.</div>';
    } else {
        // Password is valid and verified, now hash the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update the password in the database
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $new_password, $user_id);
            
            if ($stmt->execute()) {
                $password_message = '<div class="bg-green-500 p-3 rounded text-white mb-4">Password updated successfully!</div>';
                // IMPORTANT: Update the $user array in session/memory with the new hash
                $user['password'] = $new_hashed_password; 
            } else {
                $password_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Database Error: Could not update password.</div>';
            }
            $stmt->close();
        } else {
            $password_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">System Error: SQL statement preparation failed.</div>';
        }
    }
}

$upload_dir = 'uploads/profile_pics/'; // Make sure this folder exists and writable
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (isset($_POST['save_profile']) && isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/profile_pics/';
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0755, true);

    $file_tmp_path = $_FILES['profile']['tmp_name'];
    $file_ext = strtolower(pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_ext, $allowed_ext)) {
        $new_file_name = uniqid('profile_', true) . '.' . $file_ext;
        $dest_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp_path, $dest_path)) {
            // Update database user profile image path
            $sql = "UPDATE users SET profilePic = ? WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("si", $new_file_name, $user_id);
                if ($stmt->execute()) {
                    echo '<div class="bg-green-500 p-2 rounded text-white mb-4">Profile picture updated successfully!</div>';
                } else {
                    echo '<div class="bg-red-500 p-2 rounded text-white mb-4">Database update failed.</div>';
                }
                $stmt->close();
            }
        } else {
            echo '<div class="bg-red-500 p-2 rounded text-white mb-4">Failed to move uploaded file.</div>';
        }
    } else {
        echo '<div class="bg-red-500 p-2 rounded text-white mb-4">Unsupported file format.</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Dashboard - Profile</title>
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
        <?php include('topnav.php'); ?>

        <main class="flex-1 p-4 overflow-y-auto no-scrollbar">
            <h1 class="text-2xl font-bold mb-4 text-white">My Profile</h1>
            
            <form action="" method="post" enctype="multipart/form-data" class="flex items-center space-x-4 mb-8 p-4 bg-[#1f2125] rounded-xl shadow-lg">
                <div class="relative">
                    <img id="profile-pic" src="<?php if(empty($user['profilePic'])){echo 'profile.jpg';}else{echo 'uploads/profile_pics/'.$user['profilePic'];} ?>" alt="User Avatar" class="w-20 h-20 rounded-full border-2 border-gray-700 object-cover">
                    <label for="profile-upload" class="absolute bottom-0 right-0 bg-indigo-600 p-1 rounded-full cursor-pointer hover:bg-indigo-700" title="Change Profile Picture">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21H3v-3.5L16.732 3.732z" />
                        </svg>
                        <input type="file" id="profile-upload" name="profile" accept="image/*" class="hidden" onchange="previewProfilePic(event)">
                    </label>
                </div>
                <div class="flex flex-col justify-center space-y-2">
                    <h2 class="text-xl font-semibold text-white"><?php echo htmlspecialchars($user['firstname']). ' '.htmlspecialchars($user['lastname']); ?></h2>
                    <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                    <button type="submit" name="save_profile" class="bg-indigo-600 px-4 py-2 rounded text-white font-semibold hover:bg-indigo-700 transition">
                        Save
                    </button>
                    <p class="text-gray-500 text-xs mt-1">
                        User ID: <a href="https://sterlinguniongroup.com/register.php?ref_email=<?php echo htmlspecialchars($user['firstname']); ?>">
                            https://sterlinguniongroup.com/register.php?ref_email=<?php echo htmlspecialchars($user['id']); ?>
                        </a>
                    </p>
                </div>
            </form>

            <div class="space-y-4">
                <div class="bg-[#1f2125] p-6 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleSection('general-settings-content')">
                        <h3 class="text-lg font-semibold text-white">General Settings</h3>
                        <svg id="general-settings-arrow" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 transition-transform duration-300 transform rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    
                    <div id="general-settings-content" class="mt-4 hidden">
                        <?php echo $update_message; ?>
                        <form method="POST" action="">
                            <div class="space-y-4">
                                <div>
                                    <label for="firstname" class="block text-sm font-medium text-gray-400">Firstname</label>
                                    <input type="text" id="firstname" name="firstname" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                                </div>
                                <div>
                                    <label for="lastname" class="block text-sm font-medium text-gray-400">Lastname</label>
                                    <input type="text" id="lastname" name="lastname" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-400">Email Address</label>
                                    <input readonly type="email" id="email" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-gray-500 cursor-not-allowed sm:text-sm" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-400">Phone</label>
                                    <input type="text" id="phone" name="phone" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" value="<?php echo htmlspecialchars($user['phone']); ?>">
                                </div>
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-400">Address</label>
                                    <input type="text" id="address" name="address" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" value="<?php echo htmlspecialchars($user['address']); ?>">
                                </div>
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-400">Country</label>
                                    <input type="text" id="country" name="country" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" value="<?php echo htmlspecialchars($user['country']); ?>">
                                </div>
                                
                                <button type="submit" name="update_profile" class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors duration-200">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-[#1f2125] p-6 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleSection('security-content')">
                        <h3 class="text-lg font-semibold text-white">Security</h3>
                        <svg id="security-arrow" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 transition-transform duration-300 transform rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="security-content" class="mt-4 hidden">
                        <?php echo $password_message; ?>
                        
                        <form method="POST" action="">
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-400">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                </div>
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-400">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                </div>
                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium text-gray-400">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full bg-[#121417] border border-gray-700 rounded-md shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" required>
                                </div>
                                
                                <button type="submit" name="change_password" class="w-full bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition-colors duration-200">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-[#1f2125] p-6 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleSection('activity-content')">
                        <h3 class="text-lg font-semibold text-white">Recent Activity</h3>
                        <svg id="activity-arrow" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 transition-transform duration-300 transform rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <div id="activity-content" class="mt-4 hidden">
                        <ul class="space-y-2 text-sm text-gray-400">
                            <p>No new activity</p>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        
        <?php include('navbar.php'); ?>
    </div>
<script>
function previewProfilePic(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-pic').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
    <script>
        // Sidebar/menu logic
        const menuBtn = document.getElementById('menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMenu(show) {
            sidebar.classList.toggle('translate-x-full', !show);
            overlay.classList.toggle('hidden', !show);
        }

        if (menuBtn) menuBtn.addEventListener('click', () => toggleMenu(true));
        if (closeMenuBtn) closeMenuBtn.addEventListener('click', () => toggleMenu(false));
        if (overlay) overlay.addEventListener('click', () => toggleMenu(false));
        
        // Accordion logic
        function toggleSection(contentId) {
            const content = document.getElementById(contentId);
            const arrow = document.getElementById(contentId.replace('-content', '-arrow'));
            
            content.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
        
        window.toggleSection = toggleSection;
    </script>
    <script src="js/topNavFooter.js"></script>
</body>
</html>