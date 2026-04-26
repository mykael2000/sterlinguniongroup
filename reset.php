<?php
session_start();
include("exchange/account/connection.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = "";
$showForm = false;

// Check if 'token' is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate token and check expiry
    $stmt = $conn->prepare("SELECT user_id, expires_at FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $expiresAt = strtotime($row['expires_at']);
        $now = time();

        if ($now > $expiresAt) {
            $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm">This password reset link has expired.</div>';
        } else {
            $showForm = true;
            $userId = $row['user_id'];
        }
    } else {
        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm">Invalid password reset token.</div>';
    }

  
} 
if (isset($_POST['reset_password'])) {
    // Process the submitted new password form
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($password) || empty($confirmPassword)) {
        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm">Please fill in both password fields.</div>';
        $showForm = true;
    } elseif ($password !== $confirmPassword) {
        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm">Passwords do not match.</div>';
        $showForm = true;
    } else {
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Validate token again before updating for security
        $stmt = $conn->prepare("SELECT user_id, expires_at FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $expiresAt = strtotime($row['expires_at']);
            $now = time();

            if ($now > $expiresAt) {
                $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm">This password reset link has expired.</div>';
            } else {
                $userId = $row['user_id'];
                // Hash the new password securely
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Update password in users table
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $updateStmt->bind_param("si", $password, $userId);
                if ($updateStmt->execute()) {
                    // Delete the token after successful reset
                    $delStmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                    $delStmt->bind_param("s", $token);
                    $delStmt->execute();

                    $message = '<div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-2 rounded-md shadow-sm">Your password has been reset successfully! <a href="login.php" class="text-blue-600 hover:underline">Login here</a>.</div>';
                } else {
                    $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm">Failed to reset password. Please try again later.</div>';
                    $showForm = true;
                }
                $updateStmt->close();
            }
        } else {
            $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm">Invalid password reset token.</div>';
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password | Sterling Union GroupExchange</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(45, 55, 72, 0.3) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-[#111111] text-white flex items-center justify-center min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-grid-pattern">
    <div class="max-w-md w-full bg-[#111111] border border-gray-800 rounded-2xl p-8 shadow-2xl">
        <h2 class="text-3xl font-bold text-center mb-6">Reset Your Password</h2>

        <?php echo $message; ?>

        <?php if ($showForm): ?>
        <form action="" method="post" class="space-y-6" novalidate>
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />
            <div>
                <label for="password" class="block mb-1 text-gray-300">New Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="Enter new password"
                    class="w-full px-4 py-3 rounded-xl bg-[#222] border border-gray-700 placeholder-gray-500 text-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div>
                <label for="confirm_password" class="block mb-1 text-gray-300">Confirm New Password</label>
                <input id="confirm_password" name="confirm_password" type="password" required autocomplete="new-password" placeholder="Confirm new password"
                    class="w-full px-4 py-3 rounded-xl bg-[#222] border border-gray-700 placeholder-gray-500 text-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <button type="submit" name="reset_password"
                class="w-full py-3 bg-[#1c0373] hover:bg-[#380bdb] text-white font-semibold rounded-xl transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-md">
                Reset Password
            </button>
        </form>
        <?php else: ?>
        <p class="text-center mt-4">
            <a href="login.php" class="text-[#380bdb] hover:underline">Return to login</a>
        </p>
        <?php endif; ?>
    </div>
</body>
</html>
