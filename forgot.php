<?php
session_start();

include("exchange/account/connection.php");

$message = "";
require __DIR__ . '/aws/vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

if (isset($_POST['reset'])) {
    $email = trim($_POST['email']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Generate token
        $token = bin2hex(random_bytes(16));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $user = $result->fetch_assoc();
        $userId = $user['id'];

        // Store token in password_resets table
        $insertStmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token=?, expires_at=?");
        $insertStmt->bind_param("issss", $userId, $token, $expiry, $token, $expiry);
        $insertStmt->execute();

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
                        $htmlBody = "<p>You requested a password reset. Click the link below to reset your password:</p>
                           <p><a href='$resetLink'>$resetLink</a></p>
                           <p>This link will expire in 1 hour.</p>";

                        $result = $SesClient->sendEmail([
                            'Source' => 'support@sterlinguniongroup.com', // must be verified in SES
                            'Destination' => [
                                'ToAddresses' => [$email],
                            ],
                            'Message' => [
                                'Subject' => ['Data' => 'Password Reset Request'],
                                'Body' => [
                                    'Html' => ['Data' => $htmlBody],
                                ],
                            ],
                        ]);

                        $message = '<div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-2 rounded-md shadow-sm">A password reset link has been sent to your email.</div>';

                    } catch (AwsException $e) {
                        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm">Failed to send email: ' . htmlspecialchars($mail->ErrorInfo) . '</div>';
                    }
    } else {
        // Generic message to prevent email enumeration
        $message = '<div class="bg-red-100 border-l-4 border-green-500 text-green-800 p-2 rounded-md shadow-sm">No user with this email was found.</div>';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password | Sterling Union GroupExchange</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <style>
        body {
            font-family: "Inter", sans-serif;
        }
        .bg-grid-pattern {
            background-image: radial-gradient(
                rgba(45, 55, 72, 0.3) 1px,
                transparent 1px
            );
            background-size: 20px 20px;
        }
    </style>
</head>
<body
    class="bg-[#111111] text-white flex items-center justify-center min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-grid-pattern"
>
    <div
        class="max-w-4xl w-full flex flex-col md:flex-row rounded-2xl overflow-hidden shadow-2xl bg-[#111111] border border-gray-800"
    >
        <div
            class="hidden md:flex flex-1 p-8 lg:p-12 flex-col justify-between bg-[#111111] to-slate-950 relative"
        >
            <div class="absolute inset-0 z-0 opacity-20">
                nvas id="chartCanvas" class="w-full h-fullull"></canvas>
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="text-indigo-400 text-3xl font-extrabold tracking-tight">
                    <img src="sterlinglogo.png" alt="Logo" />
                </div>
                <div class="mt-auto">
                    <h1 class="text-4xl font-bold leading-tight mt-8">
                        Password Recovery
                    </h1>
                    <p class="mt-4 text-gray-300 max-w-sm">
                        Enter your registered email below, and we'll send you
                        instructions to reset your password securely.
                    </p>
                </div>
            </div>
        </div>

        <div
            class="flex-1 p-6 sm:p-10 lg:p-16 flex items-center justify-center"
        >
            <div class="w-full max-w-md">
                <h2 class="text-3xl font-bold text-center text-gray-100">
                    Forgot Your Password?
                </h2>
                <p class="text-center text-sm text-gray-400 mt-2">
                    Enter your email to reset your password
                </p>

                <?php echo $message; ?>

                <form action="" method="post" class="mt-8 space-y-6">
                    <div>
                        <label for="email" class="sr-only">Email Address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200"
                            placeholder="Email Address"
                        />
                    </div>

                    <div>
                        <button
                            name="reset"
                            type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-[#1c0373] hover:from-indigo-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md"
                        >
                            Send Reset Link
                        </button>
                    </div>

                    <p class="text-center text-sm text-gray-400 mt-2">
                        Back to
                        <a
                            href="login.php"
                            class="font-medium text-[#380bdb] hover:text-[#1c0373] transition-colors duration-200"
                            >Login</a
                        >
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        const chartCanvas = document.getElementById("chartCanvas");
        const ctx = chartCanvas.getContext("2d");
        let points = [];
        let animationFrameId;

        function resizeCanvas() {
            chartCanvas.width = chartCanvas.offsetWidth;
            chartCanvas.height = chartCanvas.offsetHeight;
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        function initPoints() {
            points = [];
            const numPoints = Math.floor(chartCanvas.width / 10);
            for (let i = 0; i <= numPoints; i++) {
                points.push({
                    x: (i * chartCanvas.width) / numPoints,
                    y: Math.random() * chartCanvas.height,
                    speed: 0.1 + Math.random() * 0.2,
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
            ctx.strokeStyle = "#818cf8";
            ctx.lineWidth = 1.5;
            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);

            for (let i = 0; i < points.length; i++) {
                points[i].y +=
                    Math.sin(Date.now() * 0.0005 + points[i].x * 0.01) *
                    points[i].speed;
                ctx.lineTo(points[i].x, points[i].y);
            }
            ctx.stroke();

            const gradient = ctx.createLinearGradient(
                0,
                0,
                0,
                chartCanvas.height
            );
            gradient.addColorStop(0, "rgba(129, 140, 248, 0.4)");
            gradient.addColorStop(0.5, "rgba(129, 140, 248, 0.1)");
            gradient.addColorStop(1, "rgba(129, 140, 248, 0)");
            ctx.fillStyle = gradient;
            ctx.lineTo(chartCanvas.width, chartCanvas.height);
            ctx.lineTo(0, chartCanvas.height);
            ctx.closePath();
            ctx.fill();

            animationFrameId = requestAnimationFrame(draw);
        }

        window.onload = function () {
            initPoints();
            draw();
        };
    </script>
</body>
</html>
