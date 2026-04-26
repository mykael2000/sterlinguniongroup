<?php
include('exchange/account/connection.php');

$registrationFeeUsd = 750.00;

$BTC = 1;
$BTCsql = "SELECT * FROM coin_wallet WHERE id = '$BTC'";
$BTCquery = mysqli_query($conn, $BTCsql);
$BTCfetch = mysqli_fetch_array($BTCquery);

$ETH = 2;
$ETHsql = "SELECT * FROM coin_wallet WHERE id = '$ETH'";
$ETHquery = mysqli_query($conn, $ETHsql);
$ETHfetch = mysqli_fetch_array($ETHquery);

$USDT = 3;
$USDTsql = "SELECT * FROM coin_wallet WHERE id = '$USDT'";
$USDTquery = mysqli_query($conn, $USDTsql);
$USDTfetch = mysqli_fetch_array($USDTquery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Fee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #121417;
            font-family: 'Inter', sans-serif;
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
        }
        #copy-message {
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
        }
        #copy-message.show {
            animation: fadeInOut 2s ease-in-out forwards;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body class="bg-[#121417] text-white">

    <div class="container">
        <div>
            <div class="mb-6">
                <h1 class="text-xl font-bold mb-1 text-white">Registration Fee Payment</h1>
                <p class="text-sm text-gray-400">Use this page only to complete your one-time account registration fee.</p>
            </div>

            <div class="bg-[#1f2125] rounded-lg p-6 space-y-4">

                <div>
                    <label for="usd-amount-field" class="block text-sm font-medium text-gray-400 mb-2">Registration Fee (USD)</label>
                    <input id="usd-amount-field" type="text" readonly class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none" value="$<?php echo number_format($registrationFeeUsd, 2); ?>">
                    <p class="mt-2 text-xs text-gray-500">
                        This amount must be paid once to complete account registration.
                    </p>
                </div>

                <div>
                    <label for="coin-select" class="block text-sm font-medium text-gray-400 mb-2">Select Coin</label>
                    <select id="coin-select" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none">
                        <option value="USDT">USDT - Tether</option>
                        <option value="BTC">BTC - Bitcoin</option>
                        <option value="ETH">ETH - Ethereum</option>
                    </select>
                </div>

                <div>
                    <label for="network-select" class="block text-sm font-medium text-gray-400 mb-2">Select Network</label>
                    <select id="network-select" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none"></select>
                </div>

                <div class="bg-[#111317] rounded-lg p-3 text-xs text-gray-300 leading-5">
                    <p class="font-semibold text-white mb-1">Before you pay:</p>
                    <p>1. Send exactly <strong>$<?php echo number_format($registrationFeeUsd, 2); ?></strong> worth of the selected coin.</p>
                    <p>2. Use only the selected network shown below.</p>
                    <p>3. Keep your transaction hash (TXID) for verification.</p>
                </div>

                <div class="text-center">
                    <p class="text-gray-400 text-sm mb-2">Scan QR code to pay registration fee</p>
                    <img id="qr-code" src="https://placehold.co/150x150/121417/d1d5db?text=QR+Code" alt="QR Code" class="mx-auto rounded-lg mb-4 border border-gray-700/50">
                    
                    <div class="bg-[#2c2e32] rounded-lg p-3 flex items-center justify-between relative">
                        <span id="deposit-address" class="text-sm text-white truncate"></span>
                        <button id="copy-button" class="ml-2 p-1 rounded-full hover:bg-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                <path d="M12 6v14"></path>
                            </svg>
                        </button>
                        <div id="copy-message" class="absolute top-[-35px] left-1/2 -translate-x-1/2 bg-green-500 text-white text-xs px-2 py-1 rounded-full opacity-0 transition-opacity duration-300">
                            Copied!
                        </div>
                    </div>
                </div>

                <div id="warning-message" class="bg-yellow-900/30 text-yellow-300 rounded-lg p-4 text-sm mt-4">
                    <p class="font-bold mb-1">Warning:</p>
                    <p>Only send the selected coin on the selected network to this address. Sending any other asset or wrong network can lead to permanent loss.</p>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        // Data for deposit addresses and networks, now including the QR code URLs from PHP
        const cryptoData = {
            'USDT': {
                'ERC20': {
                    address: '<?php echo $USDTfetch['address']; ?>',
                    qrcode: '<?php echo $USDTfetch['qrcode']; ?>',
                    warning: 'Only send USDT on the ERC20 network to this address. Sending other coins or using a different network may result in permanent loss of funds.'
                },
            },
            'BTC': {
                'Bitcoin': {
                    address: '<?php echo $BTCfetch['address']; ?>',
                    qrcode: '<?php echo $BTCfetch['qrcode']; ?>',
                    warning: 'Only send BTC to this address. Sending other coins may result in permanent loss of funds.'
                }
            },
            'ETH': {
                'ERC20': {
                    address: '<?php echo $ETHfetch['address']; ?>',
                    qrcode: '<?php echo $ETHfetch['qrcode']; ?>',
                    warning: 'Only send ETH to this address. Sending other coins may result in permanent loss of funds.'
                }
            }
        };

        const coinSelect = document.getElementById('coin-select');
        const networkSelect = document.getElementById('network-select');
        const depositAddress = document.getElementById('deposit-address');
        const qrCode = document.getElementById('qr-code');
        const warningMessage = document.getElementById('warning-message');
        const copyButton = document.getElementById('copy-button');
        const copyMessage = document.getElementById('copy-message');
        
        // Function to update the page based on the selected coin and network
        function updatePage() {
            const selectedCoin = coinSelect.value;
            const coinNetworks = Object.keys(cryptoData[selectedCoin]);
            
            // Clear and populate network options
            networkSelect.innerHTML = '';
            coinNetworks.forEach(network => {
                const option = document.createElement('option');
                option.value = network;
                option.textContent = network;
                networkSelect.appendChild(option);
            });
            
            // Trigger network change to update address and warning
            updateDetails();
        }

        // Function to update the address, QR, and warning based on the network
        function updateDetails() {
            const selectedCoin = coinSelect.value;
            const selectedNetwork = networkSelect.value;
            
            if (cryptoData[selectedCoin] && cryptoData[selectedCoin][selectedNetwork]) {
                const data = cryptoData[selectedCoin][selectedNetwork];
                depositAddress.textContent = data.address;
                qrCode.src = data.qrcode; // This is the key change!
                warningMessage.querySelector('p:nth-of-type(2)').textContent = data.warning;
            } else {
                // Handle cases where no valid network is selected
                depositAddress.textContent = 'Select a network...';
                qrCode.src = 'https://placehold.co/150x150/121417/d1d5db?text=QR+Code';
                warningMessage.querySelector('p:nth-of-type(2)').textContent = 'Please select a valid network for this coin.';
            }
        }

        // Initial setup and event listeners
        document.addEventListener('DOMContentLoaded', () => {
            updatePage(); // Initial load
            
            coinSelect.addEventListener('change', updatePage);
            networkSelect.addEventListener('change', updateDetails);

            copyButton.addEventListener('click', () => {
                const addressToCopy = depositAddress.textContent;

                if (!addressToCopy || addressToCopy === 'Select a network...') {
                    return;
                }
                
                // Use the older, more reliable method for copying in iframes
                const tempInput = document.createElement('textarea');
                tempInput.value = addressToCopy;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                // Show the "Copied!" message
                copyMessage.classList.remove('show');
                void copyMessage.offsetWidth;
                copyMessage.classList.add('show');
                setTimeout(() => {
                    copyMessage.classList.remove('show');
                }, 2000);
            });
        });
    </script>
</body>
</html>