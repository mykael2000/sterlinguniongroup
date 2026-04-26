<?php
// --- FILE: simple_referral.php ---

include('connection.php');
include('function.php');

// CRITICAL: Ensure $user is available and contains the logged-in user's data
$user_id = $user['id']; 
$user_email = $user['email']; 

// --- 1. Generate Referral Link using Email ---

// Get the base URL (adjust this to your live domain)
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

// Construct the link using the logged-in user's email
// Assumption: The registration page (index.php) accepts 'ref_email'
$referral_link = $base_url . "/register.php?ref_email=" . urlencode($user['firstname']);

// --- 2. Fetch Referred Users' Details ---
$referred_users = [];

if ($user_email && $conn) {
    // SQL: Select the first name, last name, and email of users 
    // whose 'referred_by_email' matches the current user's email.
    $sql_referrals = "SELECT firstname, lastname, email 
                      FROM users 
                      WHERE referred_by_email = ?";
    
    if ($stmt_referrals = $conn->prepare($sql_referrals)) {
        $stmt_referrals->bind_param("s", $user_email);
        $stmt_referrals->execute();
        $result_referrals = $stmt_referrals->get_result();
        
        while ($row = $result_referrals->fetch_assoc()) {
            $referred_users[] = $row;
        }
        $stmt_referrals->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Referral</title>
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
    </style>
</head>
<body class="bg-[#121417] text-gray-300">
    <div class="min-h-screen flex flex-col">
        <?php include('topnav.php'); ?>

        <main class="flex-1 p-4 overflow-y-auto no-scrollbar">
            <div id="referral-content" class="max-w-2xl mx-auto">
                <div class="mb-6">
                    <h1 class="text-xl font-bold mb-1 text-white">Invite a Friend</h1>
                    <p class="text-sm text-gray-400">Share your unique link below to start inviting users.</p>
                </div>
                
                <div class="bg-[#1f2125] rounded-lg p-6 space-y-4 mb-8 shadow-lg">
                    <h2 class="text-lg font-semibold text-white">Your Unique Referral Link</h2>
                    
                    <div class="flex items-center space-x-2">
                        <input type="text" id="referral-link-input" value="<?php echo htmlspecialchars($referral_link); ?>" readonly
                            class="flex-1 bg-[#2c2e32] text-white rounded-l-lg p-3 border-none text-sm truncate focus:outline-none">
                        
                        <button id="copy-button" 
                            class="bg-green-500 text-white font-bold py-3 px-4 rounded-r-lg hover:bg-green-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 whitespace-nowrap">
                            Copy Link
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">Your link uses your email: **<?php echo htmlspecialchars($user_email); ?>**</p>
                </div>

                <div class="bg-[#1f2125] rounded-lg p-6">
                    <h2 class="text-lg font-bold mb-4 text-white">Users Referred By You (<?php echo count($referred_users); ?>)</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700/50">
                            <thead>
                                <tr class="text-left text-sm font-semibold text-gray-400">
                                    <th class="py-3 pr-3">Name</th>
                                    <th class="py-3 pl-3">Email</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                                <?php if (!empty($referred_users)): ?>
                                    <?php foreach ($referred_users as $referred): ?>
                                        <tr class="hover:bg-[#2c2e32]">
                                            <td class="py-3 pr-3 text-sm text-white font-medium">
                                                <?php echo htmlspecialchars($referred['firstname'] . ' ' . $referred['lastname']); ?>
                                            </td>
                                            <td class="py-3 pl-3 text-sm text-gray-400">
                                                <?php echo htmlspecialchars($referred['email']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="py-4 text-center text-gray-500">
                                            No users have registered using your link yet.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?php include('navbar.php'); ?>
    </div>

    <script>
        document.getElementById('copy-button').addEventListener('click', () => {
            const linkInput = document.getElementById('referral-link-input');
            const button = document.getElementById('copy-button');
            
            // Select the text field content
            linkInput.select();
            linkInput.setSelectionRange(0, 99999); 

            // Copy the text to the clipboard
            navigator.clipboard.writeText(linkInput.value).then(() => {
                // Change button text briefly
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.classList.remove('bg-green-500');
                button.classList.add('bg-blue-500');

                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-blue-500');
                    button.classList.add('bg-green-500');
                }, 1500);
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        });
    </script>
  <script src="js/topNavFooter.js"></script>
</body>
</html>