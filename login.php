<?php
session_start();

// Make sure your connection.php file is stored in a secure location
// outside of the web root to prevent unauthorized access.
include("exchange/account/connection.php"); 

$message = "";

if (isset($_POST['login'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check database connection
    if ($conn->connect_error) {
        // In a production environment, you should log this error and show a generic message
        die("Connection failed: " . $conn->connect_error);
    }

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // "s" indicates that the parameter is a string
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user["password"];

        // Verify the password using password_verify()
        if ($password == $user['password']) {
            // Password is correct, set up session variables
            $_SESSION["user_id"] = $user["id"];
            // It's not necessary to store the email in the session, 
            // but it can be useful for display purposes.
            $_SESSION["user_email"] = $email;
            
            // Redirect to the dashboard
            header("Location: exchange/account/index.php");
            exit(); // Always call exit() after a header redirect
        } else {
            $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm" role="alert">Incorrect email or password. Please try again.</div>';
        }
    } else {
        // Use a generic message for both user not found and incorrect password
        $message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-2 rounded-md shadow-sm" role="alert">Incorrect email or password. Please try again.</div>';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sterling Union GroupExchange</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    <div class="max-w-4xl w-full flex flex-col md:flex-row rounded-2xl overflow-hidden shadow-2xl bg-[#111111] border border-gray-800">

        <div class="hidden md:flex flex-1 p-8 lg:p-12 flex-col justify-between bg-[#111111] to-slate-950 relative">
            <div class="absolute inset-0 z-0 opacity-20">
                <canvas id="chartCanvas" class="w-full h-full"></canvas>
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="text-indigo-400 text-3xl font-extrabold tracking-tight">
                    <img src='sterlinglogo.png' alt="Logo">
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

        <div class="flex-1 p-6 sm:p-10 lg:p-16 flex items-center justify-center">
            <div class="w-full max-w-md">
                <h2 class="text-3xl font-bold text-center text-gray-100">Log Into Your Account</h2>
                <p class="text-center text-sm text-gray-400 mt-2">- Better trading, Better liquidity -</p>
                <?php echo $message; ?>
                <p class="mt-2 text-center text-sm text-gray-400">
                    Don't have an account?
                    <a href="register.php" class="font-medium text-[#380bdb] hover:text-[#1c0373] transition-colors duration-200">
                        Create Account
                    </a>
                </p>

                <form action="" method="post" class="mt-8 space-y-6">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="Email Address">
                    </div>

                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none relative block w-full px-4 py-3 border border-gray-700 placeholder-gray-500 text-gray-200 rounded-xl focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-[#111111] transition-colors duration-200" placeholder="Password">
                    </div>

                    <div class="text-right text-sm">
                        <a href="forgot.php" class="font-medium text-gray-400 hover:text-[#60e336] transition-colors duration-200">
                            Forgot password?
                        </a>
                    </div>

                    <div>
                        <button name="login" type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-[#1c0373] hover:from-indigo-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md">
                            Log in
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