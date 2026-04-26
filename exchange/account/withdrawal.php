<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('connection.php');
include('function.php');

// --- PHP DATA SETUP ---
// NOTE: Replace the mock data below with your actual database queries
// to fetch the real balances for the currently logged-in user.

// Mock User Balances (Example data)
$user_balances = [
    // Assume $user is available from 'function.php'
    'USDT' => $user['total_balance'],
    'BTC'  => $user['total_balance'],
    'ETH'  => $user['total_balance']
];

// Mock Network Fees (These should ideally be fetched dynamically as well)
$network_fees = [
    'USDT' => 1.50,   // 1.5 USDT fee
    'BTC'  => 0.0002, // 0.0002 BTC fee
    'ETH'  => 0.005   // 0.005 ETH fee
];

// Define the coin-to-network mapping for JavaScript
$network_mapping = [
    'USDT' => [
        ['value' => 'TRC20', 'label' => 'TRC20 (Tron)'],
        ['value' => 'ERC20', 'label' => 'ERC20 (Ethereum)'],
        ['value' => 'BEP20', 'label' => 'BEP20 (Binance Smart Chain)']
    ],
    'BTC' => [
        ['value' => 'BTC', 'label' => 'BTC (Bitcoin Native)'],
        ['value' => 'BEP20', 'label' => 'BEP20 (Binance Smart Chain)'] // Example of wrapped BTC
    ],
    'ETH' => [
        ['value' => 'ERC20', 'label' => 'ERC20 (Ethereum Native)'],
        ['value' => 'BSC', 'label' => 'BSC (Binance Smart Chain)']
    ]
];

// Encode the PHP arrays into JSON for use in JavaScript
$json_balances = json_encode($user_balances);
$json_fees = json_encode($network_fees);
$json_networks = json_encode($network_mapping);
// --- END PHP DATA SETUP ---

$withdrawal_message = ''; // Variable to hold success/error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_otp = $_POST['OTP'] ?? '';

    // Validate OTP presence
    if (empty($input_otp)) {
        $withdrawal_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: Please enter the OTP sent to your email.</div>';
    }
    // Validate OTP exists in session and is not expired
    elseif (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expiry']) || time() > $_SESSION['otp_expiry']) {
        $withdrawal_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: OTP expired or not found. Please request a new OTP.</div>';
    }
    // Validate OTP match
    elseif ($input_otp != $_SESSION['otp']) {
        $withdrawal_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: Invalid OTP. Please check your email and try again.</div>';
    } else {
        // OTP validated successfully, clear it to prevent reuse
        unset($_SESSION['otp']);
        unset($_SESSION['otp_expiry']);

        // Now proceed with your existing withdrawal processing...
        $coin = $_POST['coin'] ?? '';
        $network = $_POST['network'] ?? '';
        $address = $_POST['address'] ?? '';
        $amount = floatval($_POST['amount']) ?? 0;
        $tranx_id = rand(100000, 999999);
      
        if (empty($coin) || empty($network) || empty($address) || $amount <= 0) {
            $withdrawal_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: Please fill in all fields correctly.</div>';
        } else {
            $available_balance = $user_balances[$coin] ?? 0;
            $network_fee = $network_fees[$coin] ?? 0;

            if ($amount > $available_balance) {
                $withdrawal_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Error: Insufficient ' . $coin . ' balance.</div>';
            } else {
                $sql = "INSERT INTO withdrawals (user_id, email, tranx_id, coin, network, address, amount, fee, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("isssssdd", $user_id, $user_email, $tranx_id, $coin, $network, $address, $amount, $network_fee);

                    if ($stmt->execute()) {
                        $withdrawal_message = '<div class="bg-green-500 p-3 rounded text-white mb-4">Success! Your withdrawal request for ' . $amount . ' ' . $coin . ' has been submitted.</div>';
                    } else {
                        $withdrawal_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">Database Error: Could not submit request.</div>';
                    }
                    $stmt->close();
                } else {
                    $withdrawal_message = '<div class="bg-red-500 p-3 rounded text-white mb-4">System Error: SQL statement preparation failed.</div>';
                }
            }
        }
    }
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Withdrawal</title>
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
            <div id="withdrawal-content">
                <div class="mb-6">
                    <h1 class="text-xl font-bold mb-1 text-white">Withdrawal</h1>
                    <p class="text-sm text-gray-400">Enter the recipient address and amount to withdraw your funds.</p>
                </div>
                <form action="" method="POST">
                  <?php echo $withdrawal_message; ?>
                <div class="bg-[#1f2125] rounded-lg p-6 space-y-4">
                    <div>
                        <label for="coin-select" class="block text-sm font-medium text-gray-400 mb-2">Select Coin</label>
                        <select id="coin-select" name="coin" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none">
                            <option value="USDT">USDT - Tether</option>
                            <option value="BTC">BTC - Bitcoin</option>
                            <option value="ETH">ETH - Ethereum</option>
                        </select>
                    </div>

                    <div>
                        <label for="network-select" class="block text-sm font-medium text-gray-400 mb-2">Select Network</label>
                        <select id="network-select" name="network" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none">
                        </select>
                    </div>

                    <div>
                        <label for="address-input" class="block text-sm font-medium text-gray-400 mb-2">Withdrawal Address</label>
                        <input type="text" id="address-input" name="address" placeholder="Enter recipient address" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="amount-input" class="block text-sm font-medium text-gray-400 mb-2">Amount</label>
                        <input type="number" id="amount-input" name="amount" placeholder="Enter amount" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none">
                        <div class="text-xs text-gray-500 mt-2">
                            Available: $<span id="available-balance" ><?php echo $user['total_balance']; ?></span>
                        </div>
                    </div>
					
                  	<div>
                      

                        <label for="otp-input" class="block text-sm font-medium text-gray-400 mb-2">OTP</label>
                        <input type="text" id="otp-input" name="OTP" placeholder="Enter OTP" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none">
                      <div class="text-xs text-gray-500 mt-2">
                        	<button type="button" id="send-otp-btn" class="bg-green-800 rounded-lg text-white font-bold p-2">Send OTP</button><div id="otp-message" class="text-green-500 font-semibold mb-2"></div>
                       </div>
                    </div>
                  
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center text-gray-400">
                            <span>Network Fee</span>
                            <span id="network-fee">0.00 <span class="coin-unit">USDT</span></span>
                        </div>
                        <div class="flex justify-between items-center text-white font-semibold">
                            <span>You'll Get</span>
                            <span id="receive-amount">0.00 <span class="coin-unit">USDT</span></span>
                        </div>
                    </div>

                    <button type="submit" id="withdraw-button" class="w-full bg-green-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-[#1f2125] opacity-50 cursor-not-allowed" disabled>
                        Withdraw
                    </button>
                </div>
              </form>
                <div class="mt-8">
                  <h2 class="text-xl font-bold mb-4 text-white">Withdrawal History</h2>
                  <div class="bg-[#1f2125] rounded-lg p-4">
                      <div class="flex justify-between items-center py-2 border-b border-gray-700/50 text-sm text-gray-400 font-semibold">
                          <span>Date</span>
                          <span>Coin</span>
                          <span>Amount</span>
                          <span>Status</span>
                      </div>

                      <?php 
                      // Start the loop to iterate through the results
                      if (mysqli_num_rows($query_with) > 0) {
                          while ($withdrawal = mysqli_fetch_assoc($query_with)) {
                              // Determine the status color
                              $status_class = '';
                              switch (strtolower($withdrawal['status'])) {
                                  case 'completed':
                                      $status_class = 'text-green-500';
                                      break;
                                  case 'pending':
                                  case 'processing':
                                      $status_class = 'text-yellow-500';
                                      break;
                                  case 'failed':
                                  case 'cancelled':
                                      $status_class = 'text-red-500';
                                      break;
                                  default:
                                      $status_class = 'text-gray-400';
                                      break;
                              }

                              // Format the date (assuming the database column is named 'request_date')
                              $formatted_date = date('Y-m-d', strtotime($withdrawal['created_at']));

                              // Determine the border class for all but the last item
                              // This is a common way to handle the last item's border in a loop
                              $border_class = 'border-b border-gray-700/50'; 
                              // A more accurate check would require knowing the current row count vs total rows,
                              // but this simple approach is fine for now.
                      ?>

                      <div class="flex justify-between items-center py-2 <?php echo $border_class; ?>">
                          <span class="text-sm text-gray-400"><?php echo htmlspecialchars($formatted_date); ?></span>
                          <span class="text-sm text-white"><?php echo htmlspecialchars($withdrawal['coin']); ?></span>
                          <span class="text-sm text-white"><?php echo number_format($withdrawal['amount'], 8); ?></span>
                          <span class="text-sm <?php echo $status_class; ?>"><?php echo htmlspecialchars(ucfirst($withdrawal['status'])); ?></span>
                      </div>

                      <?php 
                          } // End while loop
                      } else { 
                      ?>
                      <div class="py-4 text-center text-gray-500">
                          No withdrawal history found.
                      </div>
                      <?php
                      }
                      ?>

                  </div>
              </div>
            </div>
        </main>

        <?php include('navbar.php'); ?>
    </div>

    <script>
      document.getElementById('send-otp-btn').addEventListener('click', function () {
    const userEmail = '<?php echo addslashes($user_email); ?>'; // get user email securely

    fetch('send_otp.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: userEmail })
    })
    .then(response => response.json())
    .then(data => {
        const otpMessageDiv = document.getElementById('otp-message');
        if (data.success) {
            otpMessageDiv.textContent = data.message;
            otpMessageDiv.classList.remove('text-red-500');
            otpMessageDiv.classList.add('text-green-500');
        } else {
            otpMessageDiv.textContent = data.message;
            otpMessageDiv.classList.remove('text-green-500');
            otpMessageDiv.classList.add('text-red-500');
        }
    })
    .catch(() => {
        const otpMessageDiv = document.getElementById('otp-message');
        otpMessageDiv.textContent = 'Error sending OTP. Please try again.';
        otpMessageDiv.classList.remove('text-green-500');
        otpMessageDiv.classList.add('text-red-500');
    });
});

        document.addEventListener('DOMContentLoaded', () => {
            const coinSelect = document.getElementById('coin-select');
            const networkSelect = document.getElementById('network-select'); // New element
            const amountInput = document.getElementById('amount-input');
            const networkFeeSpan = document.getElementById('network-fee');
            const receiveAmountSpan = document.getElementById('receive-amount');
            const withdrawButton = document.getElementById('withdraw-button');
            const availableBalanceSpan = document.getElementById('available-balance');
            const availableCoinUnitSpan = document.getElementById('available-coin-unit');
            const coinUnitSpans = document.querySelectorAll('.coin-unit');

            // Get data from PHP
            const coinBalances = <?php echo $json_balances; ?>;
            const networkFees = <?php echo $json_fees; ?>;
            const networkMapping = <?php echo $json_networks; ?>; // New data
            
            let currentCoin = coinSelect.value;
            let currentBalance = coinBalances[currentCoin];
            let currentFee = networkFees[currentCoin];
            
            // Function to format value based on coin precision
            function formatValue(coin, value) {
                if (coin === 'BTC') {
                    return value.toFixed(8); // High precision for Bitcoin
                } else if (coin === 'ETH') {
                    return value.toFixed(6); // Medium precision for Ethereum
                } else {
                    return value.toFixed(2); // Standard precision for USDT (or similar stablecoin)
                }
            }

            // Function to update network options based on the selected coin
            function updateNetworkOptions() {
                const selectedCoin = coinSelect.value;
                const networks = networkMapping[selectedCoin] || [];

                // Clear existing options
                networkSelect.innerHTML = ''; 

                if (networks.length === 0) {
                    // Handle case where no networks are defined (e.g., show a placeholder)
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No networks available';
                    networkSelect.appendChild(option);
                    return;
                }

                // Populate with new options
                networks.forEach(network => {
                    const option = document.createElement('option');
                    option.value = network.value;
                    option.textContent = network.label;
                    networkSelect.appendChild(option);
                });
            }

            // Updates available balance, fee unit, and triggers amount recalculation
            function updateCoinData() {
                currentCoin = coinSelect.value;
                currentBalance = coinBalances[currentCoin];
                currentFee = networkFees[currentCoin];
                
                // NEW: Update the network options first
                updateNetworkOptions();

                // 1. Update available balance display
                availableBalanceSpan.textContent = formatValue(currentCoin, currentBalance);
                availableBalanceSpan.setAttribute('data-coin', currentCoin);
                availableCoinUnitSpan.textContent = currentCoin;

                // 2. Update all coin units (Network Fee and You'll Get)
                coinUnitSpans.forEach(span => {
                    span.textContent = currentCoin;
                });
                
                // 3. Update network fee display
                networkFeeSpan.textContent = `${formatValue(currentCoin, currentFee)} ${currentCoin}`;

                // 4. Clear input and trigger amount update for the new coin
                amountInput.value = ''; 
                updateAmounts();
            }

            // Calculates received amount, handles validation, and updates button/input color
            function updateAmounts() {
                const amount = parseFloat(amountInput.value);
                const currentCoin = coinSelect.value;
                const currentBalance = coinBalances[currentCoin];
                const currentFee = networkFees[currentCoin];

                // Default state for receive amount and button
                let receivedDisplay = '0.00';
                withdrawButton.disabled = true;
                withdrawButton.classList.add('opacity-50', 'cursor-not-allowed');
                amountInput.classList.remove('text-red-500'); // Reset color

                if (isNaN(amount) || amount <= 0) {
                    receiveAmountSpan.innerHTML = `0.00 <span class="coin-unit">${currentCoin}</span>`;
                    return;
                }

                // --- BALANCE CHECK AND COLOR CHANGE LOGIC ---
                if (amount > currentBalance) {
                    // Amount exceeds available balance: Turn input text red
                    amountInput.classList.add('text-red-500');
                    withdrawButton.disabled = true;
                    // Calculate received amount even if it's invalid, for instant feedback
                    receivedDisplay = formatValue(currentCoin, amount - currentFee);
                } else {
                    // Amount is valid: Enable button and calculate
                    amountInput.classList.remove('text-red-500');
                    withdrawButton.disabled = false;
                    withdrawButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    
                    const received = amount - currentFee;
                    receivedDisplay = formatValue(currentCoin, Math.max(0, received));
                }
                // --- END BALANCE CHECK LOGIC ---

                receiveAmountSpan.innerHTML = `${receivedDisplay} <span class="coin-unit">${currentCoin}</span>`;
            }

            // Event listeners
            coinSelect.addEventListener('change', updateCoinData);
            amountInput.addEventListener('input', updateAmounts);
            // NOTE: You might want to update amounts if the network changes (as fee might change),
            // but since fee is currently fixed by coin, this is optional for now.
            // networkSelect.addEventListener('change', updateAmounts); 

            // Initial setup
            updateCoinData();
        });
    </script>
    <script src="js/topNavFooter.js"></script>
</body>
</html>