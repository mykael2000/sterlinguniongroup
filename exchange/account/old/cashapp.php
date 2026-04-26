<?php
include("connection.php");
ob_start();
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: ../sign.htm"); // Redirect to the login page if not logged in
    exit();
}


// Get user information from the session
$user_id = $_SESSION["user_id"];

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
}
$user_email = $row['email'];

if(!empty($_GET['amount'])){
  $amount = $_GET['amount'];
  $plan = $_GET['plan'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashapp Payment</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
    }

    .container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #qrcode {
        margin: 0 auto;
        /* Center-align the QR code */
    }

    .wallet-address {
        background-color: #f0f0f0;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cashapp Payment</h1>
      <p>You are required to pay the sum of $<?php echo $amount; ?> to the cashapp tag below.</p>
      <p>Plan: <?php echo $plan; ?></p>
      <p><b>Note:</b> Ensure that you are sending funds to the correct cashapp tag. Sending funds to wrong tags may result in loss of your deposit.</p>

        <!-- Display the QR Code -->
        <div id="qrcode"></div>

       
        <!-- Wallet Address with Copy Button -->
        <div class="wallet-address">
            <strong><?php echo $row['cashapp']; ?></strong>
            <button onclick="copyToClipboard()">Copy Address</button>
        </div>

        <p>Your balance will automatically be updated once the payment is confirmed.</p>
        <!--<span>Made payment? Send proof of payment here <a
                href="deposit.php?payment=true&&coin=USDT">Upload proof of payment</a></span>-->
    </div>

    <!-- Include the QRCode.js library -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
    // Generate the QR code
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "<?php echo $row['cashapp']; ?>",
        width: 128,
        height: 128,
    });

    // Function to copy the wallet address to clipboard
    function copyToClipboard() {
        var walletAddress = document.querySelector('.wallet-address strong');
        var textArea = document.createElement("textarea");
        textArea.value = walletAddress.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert("Cashapp tag copied to clipboard: " + walletAddress.textContent);
    }
    </script>
</body>

</html>