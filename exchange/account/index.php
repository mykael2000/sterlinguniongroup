<?php
require('connection.php');
require('function.php');

$BTC = 1;
$BTCsql = "SELECT * FROM wallet WHERE id = '$BTC'";
$BTCquery = mysqli_query($conn, $BTCsql);
$BTCfetch = mysqli_fetch_array($BTCquery);

$ETH = 2;
$ETHsql = "SELECT * FROM wallet WHERE id = '$ETH'";
$ETHquery = mysqli_query($conn, $ETHsql);
$ETHfetch = mysqli_fetch_array($ETHquery);

$USDT = 3;
$USDTsql = "SELECT * FROM wallet WHERE id = '$USDT'";
$USDTquery = mysqli_query($conn, $USDTsql);
$USDTfetch = mysqli_fetch_array($USDTquery);

$SOL = 4;
$SOLsql = "SELECT * FROM wallet WHERE id = '$SOL'";
$SOLquery = mysqli_query($conn, $SOLsql);
$SOLfetch = mysqli_fetch_array($SOLquery);
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
        <?php include('topnav.php'); ?>
        <!-- Main Content -->
        <main class="flex-1 p-4 overflow-y-auto no-scrollbar">
            <!-- Nav tabs -->
            <div class="flex items-center space-x-4 mb-4 text-sm font-medium border-b border-gray-700/50 pb-2 overflow-x-auto no-scrollbar">
                
                <button id="spot-tab" class="text-white px-2 py-1 rounded-full border-b-2 border-green-500 font-semibold transition-colors duration-200">Assets Dashboard</button>
                <button id="futures-tab" class="text-gray-400 px-2 py-1 rounded-full hover:text-white transition-colors duration-200">Trading Portfolio</button>
                <button id="new-listing-tab" id="" class="text-gray-400 px-2 py-1 rounded-full hover:text-white transition-colors duration-200">Pre-launch token</button>
                <button id="deposit-tab" class="text-gray-400 px-2 py-1 rounded-full hover:text-white transition-colors duration-200">Deposit</button>
                <a href="withdrawal.php" class="text-gray-400 px-2 py-1 rounded-full hover:text-white transition-colors duration-200">Withdrawal</a>
                
            </div>
            
           

            <!-- Spot Account Content -->
            <div id="spot-content">
                <!-- Account Summary -->
                <div class="mb-6">
                    <h1 class="text-xl font-bold mb-1 text-white"></h1>
                    <div class="flex items-center text-gray-400 text-sm mb-2">
                        <span class="mr-1">Total Assets</span>
                        <!--<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>-->
                    </div>
                    <div class="flex items-center mb-1">
                        <span class="text-3xl font-bold text-white"><?php echo number_format($user['btc_balance']*get_crypto_price_usd('bitcoin') + $user['sol_balance']*get_crypto_price_usd('solana')  + 
  																	$user['usdt_balance'] + $user['eth_balance']* get_crypto_price_usd('ethereum'),2,'.',',');  ?></span>
                        <span class="text-lg font-bold text-gray-400 ml-2">USDT</span>
                        <!--<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>-->
                    </div>
                    <div class="text-sm text-gray-400"> $<?php echo number_format($user['btc_balance']*get_crypto_price_usd('bitcoin') + $user['sol_balance']*get_crypto_price_usd('solana') + 
  																	$user['usdt_balance'] + $user['eth_balance']* get_crypto_price_usd('ethereum'),2,'.',',');  ?></div>

                    <div class="flex justify-between items-center mt-4 border-t border-gray-700/50 pt-4">
                        <div>
                            <div class="text-xs text-gray-400 mb-1">Today's PnL</div>
                            <div class="text-green-500 font-bold">$<?php if(!empty($user['today_pnl'])){echo number_format($user['today_pnl'],2,'.',',');}else{echo 0.00;} ?> <span class="ml-1"><?php if(!empty($user['today_pnl_percentage'])){echo number_format($user['today_pnl_percentage'],2,'.',',');}else{echo 0.00;} ?>%</span></div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8L11 20" />
                        </svg>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-around mb-6 text-center">
                    <button id="deposit-tab2" class="flex flex-col items-center p-3 rounded-lg hover:bg-[#1f2125]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="text-sm">Deposit</span>
                    </button>
                    <a href="withdrawal.php" class="flex flex-col items-center p-3 rounded-lg hover:bg-[#1f2125]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5m0 0h.01m0 0v5m-4-5h.01m0-5h.01M20 20v-5m0 0h.01m0 0v-5m4 5h.01m0 5h.01M12 4v16m0-8h.01" />
                        </svg>
                        <span class="text-sm">Withdraw</span>
                    </a>
                    <!--<a href="withdrawal.php" class="flex flex-col items-center p-3 rounded-lg hover:bg-[#1f2125]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span class="text-sm">Transfer</span>
                    </a>-->
                </div>

                <!-- Search Bar -->
                <div class="mb-6 relative">
                    <input type="text" placeholder="Search" class="w-full bg-[#1f2125] text-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-1 focus:ring-green-500 pr-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Asset List Header -->
                <div class="flex items-center justify-between mb-4 text-sm text-gray-400 border-b border-gray-700/50 pb-2">
                    <div class="flex items-center space-x-2">
                        <!--<input type="checkbox" id="hideZero" class="form-checkbox h-4 w-4 text-green-500 bg-gray-800 rounded focus:ring-green-500">
                        <label for="hideZero">Hide 0 balance assets</label>-->
                    </div>
                    <div class="text-right">Coin</div>
                    <div class="text-right">Total</div>
                </div>

                <!-- Asset List (Repeating Block) -->
                <div class="space-y-4">
                    <!-- BTC -->
                    <div class="flex items-center justify-between py-2 border-b border-gray-700/50">
                        <div class="flex items-center">
                            <img src="Bitcoin.svg.webp" alt="Bitcoin logo" class="w-8 h-8 rounded-full mr-3">
                            <div>
                                <div class="text-white font-semibold">BTC</div>
                                <div class="text-xs text-gray-400">Bitcoin</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white font-semibold"><?php echo $user['btc_balance']; ?></div>
                            <div class="text-xs text-gray-400">≈ $<?php echo number_format($user['btc_balance']*get_crypto_price_usd('bitcoin'),2, '.', ','); ?></div>
                        </div>
                    </div>

                    <!-- USDT -->
                    <div class="flex items-center justify-between py-2 border-b border-gray-700/50">
                        <div class="flex items-center">
                            <img src="tether.svg" alt="Tether logo" class="w-8 h-8 rounded-full mr-3">
                            <div>
                                <div class="text-white font-semibold">USDT</div>
                                <div class="text-xs text-gray-400">Tether</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white font-semibold"><?php echo $user['usdt_balance']; ?></div>
                            <div class="text-xs text-gray-400">≈ $<?php echo number_format($user['usdt_balance'], 2, '.', ','); ?></div>
                        </div>
                    </div>

                    <!-- ETH -->
                    <div class="flex items-center justify-between py-2 border-b border-gray-700/50">
                        <div class="flex items-center">
                            <img src="eth.svg" alt="Ethereum logo" class="w-8 h-8 rounded-full mr-3">
                            <div>
                                <div class="text-white font-semibold">ETH</div>
                                <div class="text-xs text-gray-400">Ethereum</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white font-semibold"><?php echo $user['eth_balance']; ?></div>
                            <div class="text-xs text-gray-400"> $<?php echo number_format($user['eth_balance']* get_crypto_price_usd('ethereum'),2,'.',','); ?></div>
                        </div>
                    </div>
                  
                  <!-- SOL -->
                    <div class="flex items-center justify-between py-2 border-b border-gray-700/50">
                        <div class="flex items-center">
                            <img src="Solana_logo.png" alt="Solana logo" class="w-8 h-8 rounded-full mr-3">
                            <div>
                                <div class="text-white font-semibold">SOL</div>
                                <div class="text-xs text-gray-400">Solana</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white font-semibold"><?php echo $user['sol_balance']; ?></div>
                            <div class="text-xs text-gray-400">≈ $<?php echo number_format($user['sol_balance']*get_crypto_price_usd('solana'),2,'.',','); ?></div>
                        </div>
                    </div>
                  
                  <!-- GENUIS -->
                    <div class="flex items-center justify-between py-2 border-b border-gray-700/50">
                        <div class="flex items-center">
                            <img src="https://placehold.co/32x32/3c3c3d/ffffff?text=GEN" alt="Solana logo" class="w-8 h-8 rounded-full mr-3">
                            <div>
                                <div class="text-white font-semibold">GEN</div>
                                <div class="text-xs text-gray-400">Genuis</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white font-semibold"><?php echo $user['gen_balance']; ?></div>
                            <div class="text-xs text-gray-400"> $<?php echo $user['gen_usdt_balance']; ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Futures Account Content (Initially hidden) -->
            <div id="futures-content" class="hidden">
              <div class="space-y-6">
                <div class="bg-[#111212] p-6 rounded-lg shadow-md">
                  <h1 class="text-2xl font-extrabold text-white mb-3">Trading Account</h1>
                  <div class="flex items-center text-gray-400 text-sm mb-4">
                    <span class="mr-1">Total Balance (USD)</span>
                  </div>
                  <div class="flex items-center mb-2">
                    <span class="text-4xl font-extrabold text-white">$<?php echo number_format($user['total_balance'], 2, '.', ','); ?></span>
                    
                  </div>
                 
                  
                </div>

                <!-- Reusable card style for other sections -->
                <div class="bg-green-800 p-6 rounded-lg shadow-md">
                  <h1 class="text-2xl font-extrabold text-white mb-3">Total Deposits</h1>
                  <div class="flex items-center">
                    <span class="text-4xl font-extrabold text-white">$<?php echo number_format($user['total_deposits'], 2, '.', ','); ?></span>
                  </div>
                </div>

                <div class="bg-green-800 p-6 rounded-lg shadow-md">
                  <h1 class="text-2xl font-extrabold text-white mb-3">Active Deposits</h1>
                  <div class="flex items-center">
                    <span class="text-4xl font-extrabold text-white">$<?php echo number_format($user['active_deposits'], 2, '.', ','); ?></span>
                  </div>
                </div>

                <div class="bg-green-800 p-6 rounded-lg shadow-md">
                  <h1 class="text-2xl font-extrabold text-white mb-3">Total Earnings</h1>
                  <div class="flex items-center">
                    <span class="text-4xl font-extrabold text-white">$<?php echo number_format($user['total_earnings'], 2, '.', ','); ?></span>
                  </div>
                </div>

                <div class="bg-green-800 p-6 rounded-lg shadow-md">
                  <h1 class="text-2xl font-extrabold text-white mb-3">Total Referrals</h1>
                  <div class="flex items-center">
                    <span class="text-4xl font-extrabold text-white"><?php echo intval($user['total_referrals'] ?? 0); ?></span>
                  </div>
                </div>

                <div class="bg-green-800 p-6 rounded-lg shadow-md">
                  <h1 class="text-2xl font-extrabold text-white mb-3">Total Withdrawals</h1>
                  <div class="flex items-center">
                    <span class="text-4xl font-extrabold text-white">$<?php echo number_format($user['total_withdrawals'], 2, '.', ','); ?></span>
                  </div>
                </div>

                <div class="bg-green-800 p-6 rounded-lg shadow-md">
                  <h1 class="text-2xl font-extrabold text-white mb-3">Pending Withdrawals</h1>
                  <div class="flex items-center">
                    <span class="text-4xl font-extrabold text-white">$<?php echo number_format($user['pending_withdrawals'], 2, '.', ','); ?></span>
                  </div>
                </div>
              </div>


                <!--<div class="flex justify-around mb-6 text-center">
                    <button class="flex flex-col items-center p-3 rounded-lg hover:bg-[#1f2125]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="text-sm">Positions</span>
                    </button>
                    <button class="flex flex-col items-center p-3 rounded-lg hover:bg-[#1f2125]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M12 16h.01" />
                        </svg>
                        <span class="text-sm">History</span>
                    </button>
                    <button class="flex flex-col items-center p-3 rounded-lg hover:bg-[#1f2125]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span class="text-sm">Transfer</span>
                    </button>
                </div>-->
                <div class="mt-8">
                    <h2 class="text-xl font-bold mb-4 text-white">Investment Plans</h2>
                    <div class="space-y-4">
                        <div class="bg-[#1f2125] rounded-lg p-6 shadow-md border border-gray-700/50">
                            <h3 class="text-lg font-bold text-white mb-2">Basic Plan</h3>
                            <p class="text-sm text-gray-400 mb-4">A great starting point for new investors.</p>
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div class="text-gray-400">Min. Deposit: <span class="text-white font-semibold">$899</span></div>
                                <div class="text-gray-400">Max. Deposit: <span class="text-white font-semibold">$9,999</span></div>
                                <div class="text-gray-400">Profit Rate: <span class="text-green-500 font-semibold">19%</span></div>
                                <!-- <div class="text-gray-400">Duration: <span class="text-white font-semibold">7 days</span></div> -->
                                <!-- <div class="text-gray-400">Withdrawal: <span class="text-white font-semibold">Daily</span></div> -->
                            </div>
                            <button onclick="window.location.href='index.php?page=deposit'" class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                Invest Now
                            </button>
                        </div>

                        <div class="bg-[#1f2125] rounded-lg p-6 shadow-md border border-gray-700/50">
                            <h3 class="text-lg font-bold text-white mb-2">Standard Plan</h3>
                            <p class="text-sm text-gray-400 mb-4">Balanced risk and reward for steady growth.</p>
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div class="text-gray-400">Min. Deposit: <span class="text-white font-semibold">$10,000</span></div>
                                <div class="text-gray-400">Max. Deposit: <span class="text-white font-semibold">$79,999</span></div>
                                <div class="text-gray-400">Profit Rate: <span class="text-green-500 font-semibold">23% </span></div>
                                <!-- <div class="text-gray-400">Duration: <span class="text-white font-semibold">14 days</span></div> -->
                                <!-- <div class="text-gray-400">Withdrawal: <span class="text-white font-semibold">Daily</span></div> -->
                            </div>
                            <button onclick="window.location.href='index.php?page=deposit'" class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                Invest Now
                            </button>
                        </div>
                        
                        <div class="bg-[#1f2125] rounded-lg p-6 shadow-md border border-gray-700/50">
                            <h3 class="text-lg font-bold text-white mb-2">Premium Plan</h3>
                            <p class="text-sm text-gray-400 mb-4">Optimized for experienced investors.</p>
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div class="text-gray-400">Min. Deposit: <span class="text-white font-semibold">$80,000</span></div>
                                <div class="text-gray-400">Max. Deposit: <span class="text-white font-semibold">$299,999</span></div>
                                <div class="text-gray-400">Profit Rate: <span class="text-green-500 font-semibold">32%</span></div>
                                <!-- <div class="text-gray-400">Duration: <span class="text-white font-semibold">30 days</span></div> -->
                                <!-- <div class="text-gray-400">Withdrawal: <span class="text-white font-semibold">Daily</span></div> -->
                            </div>
                            <button onclick="window.location.href='index.php?page=deposit'" class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                Invest Now
                            </button>
                        </div>
                        
                        <div class="bg-[#1f2125] rounded-lg p-6 shadow-md border border-gray-700/50">
                            <h3 class="text-lg font-bold text-white mb-2">Executive Plan</h3>
                            <p class="text-sm text-gray-400 mb-4">Exclusive access for high-volume traders.</p>
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div class="text-gray-400">Min. Deposit: <span class="text-white font-semibold">$300,000</span></div>
                                <div class="text-gray-400">Max. Deposit: <span class="text-white font-semibold">$6,000,000</span></div>
                                <div class="text-gray-400">Profit Rate: <span class="text-green-500 font-semibold">42%</span></div>
                                <!-- <div class="text-gray-400">Duration: <span class="text-white font-semibold">90 days</span></div> -->
                                <!-- <div class="text-gray-400">Withdrawal: <span class="text-white font-semibold">Daily</span></div> -->
                            </div>
                            <button onclick="window.location.href='index.php?page=deposit'" class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                Invest Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New Listing Content (New Section) -->
            <div id="new-listing-content" class="hidden">
                <section id="tapper-section" class="flex flex-col items-center container mx-auto px-4">
                    <h2 class="text-center text-2xl font-bold mb-4">Tap to Claim Your Free Genuis Token!</h2>
                    <div id="coin-container" class="flex flex-col items-center">
                        <img height="300px" width="300px" id="coin-image" src="genuis.png" alt="Tappable Coin">
                    </div>
                    <div id="tap-count" class="mt-4 text-xl font-bold">Taps: <span id="taps">0</span></div>

                    <p id="timer-label" class="mt-12">Token Listing in:</p>
                    <div id="countdown-timer"></div>
                    <div class="flex justify-center mt-4 space-x-4">
                        <a href="payment.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full transition-colors duration-300">Buy Token</a>
                        <a href="" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-full transition-colors duration-300">Whitepaper</a>
                    </div>
                </section>
                <div class="mb-6">
                    <h1 class="text-xl font-bold mb-1 text-white pt-4">Genuis Community</h1>

                </div>
                <div class="mt-4 p-2 rounded-xl bg-gray-900 border border-gray-700 shadow-xl">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-300">Community sentiment</span>
                        <div class="text-sm text-gray-500">4.7M votes</div>
                    </div>

                    <div class="flex items-center mb-6">
                        <div class="flex items-center w-full">
                            <div class="text-green-accent mr-2 font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8L11 2m-3 15h4v4m-4 0v-4m-4 0h4m-4 0v-4" />
                                </svg>
                                82%
                            </div>
                            <div class="w-full h-2 bg-gray-800 rounded-full flex overflow-hidden">
                                <div class="h-full bg-[#177a04]" style="width: 82%;"></div>
                                <div class="h-full bg-red-600" style="width: 18%;"></div>
                            </div>
                            <div class="text-red-600 ml-2 font-semibold">
                                18%
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8L11 2m-3 15h4v4m-4 0v-4m-4 0h4m-4 0v-4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button class="flex items-center justify-center bg-green-600 py-3 rounded-xl border border-gray-700 text-white font-semibold hover:text-black transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8L11 2m-3 15h4v4m-4 0v-4m-4 0h4m-4 0v-4" />
                            </svg>
                            Bullish
                        </button>
                        <button class="flex items-center justify-center bg-red-600 py-3 rounded-xl border border-gray-700 text-white font-semibold hover:text-black transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8L11 2m-3 15h4v4m-4 0v-4m-4 0h4m-4 0v-4" />
                            </svg>
                            Bearish
                        </button>
                    </div>
                </div>
                <!-- <div class="mt-4 p-2 rounded-xl bg-gray-900 border border-gray-700 shadow-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-gray-700 mr-4"></div>
                        <div>
                            <div class="flex items-center">
                                <span class="text-lg font-semibold">Crypto.Andy</span>
                                <svg class="w-4 h-4 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="text-sm text-gray-500 ml-2">15 hours</span>
                            </div>
                            <button class="text-sm font-semibold text-green-accent">
                                + Follow
                            </button>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4">Let's kick off this day productively - with fresh ideas and useful resources. Today I'm sharing an insightful article "Building a Smart Corporate Crypto Reserve: My Top 5 Picks". The author explores... <span class="text-green-accent font-semibold">Read all</span></p>

                    <div class="rounded-xl overflow-hidden mb-4">
                        <img src="https://placehold.co/600x400/1e293b/fff?text=Corporate+Crypto+Reserve" alt="Corporate Crypto Reserve" class="w-full h-auto">
                    </div>

                    <div class="text-sm text-gray-500 text-center mb-4">
                        See more <a href="#" class="text-green-accent font-semibold">#BTC Price Analysis</a> posts >
                    </div>

                    <div class="flex justify-between items-center text-gray-400 text-sm">
                        <div class="flex items-center space-x-2">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                </svg>
                                27
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                623
                            </span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h2a2 2 0 002-2V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v10a2 2 0 002 2h2" />
                                </svg>
                                20
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8a2 2 0 012 2v8a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2z" />
                                </svg>
                                14
                            </span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.636a2 2 0 01-1.789-2.894l3.5-7zM7 9H2.236a2 2 0 00-1.789 2.894l3.5 7A2 2 0 008.736 21h4.636a2 2 0 001.789-2.894l-3.5-7z" />
                                </svg>
                                701
                            </span>
                        </div>
                    </div>
                </div> -->
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($article = mysqli_fetch_assoc($result)) {
                        // Truncate content for a shorter preview
                        $preview_content = substr($article['content'], 0, 150);
                        if (strlen($article['content']) > 150) {
                            $preview_content .= '...';
                        }
                        
                        // Format creation time
                        $created_at = new DateTime($article['created_at']);
                        $now = new DateTime();
                        $interval = $now->diff($created_at);
                        $time_ago = '';
                        if ($interval->y > 0) {
                            $time_ago = $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
                        } elseif ($interval->m > 0) {
                            $time_ago = $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
                        } elseif ($interval->d > 0) {
                            $time_ago = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
                        } elseif ($interval->h > 0) {
                            $time_ago = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
                        } elseif ($interval->i > 0) {
                            $time_ago = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
                        } else {
                            $time_ago = 'Just now';
                        }
                ?>
                <div class="mt-4 p-2 rounded-xl bg-gray-900 border border-gray-700 shadow-xl">
                    <div class="flex items-center mb-4">
                        
                            <div class="w-10 h-10 rounded-full bg-gray-700 mr-4">
                                <img src="../../admin/<?php echo htmlspecialchars($article['author_image_url']); ?>" alt="Author's Image" class="w-10 h-10 rounded-full">
                            </div>
                            <div>
                                <a href="<?php echo htmlspecialchars($article['author_profile_link']); ?>">
                                    <div class="flex items-center">
                                        <span class="text-lg font-semibold"><?php echo htmlspecialchars($article['author_name']); ?></span>
                                        <svg class="w-4 h-4 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span class="text-sm text-gray-500 ml-2"><?php echo $time_ago; ?></span>
                                    </div>
                                </a>
                                
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        <?php echo $article['followers']; ?> followers
                                    </span> 
                            </div>
                        
                    </div>
                    
                    <p class="text-gray-300 mb-4"><?php echo $preview_content; ?> <span class="text-green-accent font-semibold">Read all</span></p>


                    <div class="flex justify-between items-center text-gray-400 text-sm">
                        <div class="flex items-center space-x-2">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.636a2 2 0 01-1.789-2.894l3.5-7zM7 9H2.236a2 2 0 00-1.789 2.894l3.5 7A2 2 0 008.736 21h4.636a2 2 0 001.789-2.894l-3.5-7z" />
                                </svg>
                                <span class="text-white">Upvotes: <?php echo $article['upvotes']; ?></span>
                            </span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14L5.236 7.106a2 2 0 013.528-2.212l3.236 5.163zM14 14l4.764-6.894a2 2 0 00-3.528-2.212l-3.236 5.163z" />
                                </svg>
                                <span class="text-white">Downvotes: <?php echo $article['downvotes']; ?></span>
                            </span>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<div class='col-md-12 text-center'><p>No articles found.</p></div>";
                }
                ?>

            </div>

            <!-- Deposit Content (New Section) -->
           <div id="deposit-content">
            <div class="mb-6">
                <h1 class="text-2xl font-bold mb-1 text-white">Deposit</h1>
                <p class="text-sm text-gray-400">Select the coin and network to get your deposit address.</p>
            </div>

            <!-- Deposit Form -->
            <div class="bg-[#1f2125] rounded-xl p-6 space-y-4 shadow-lg">
                <!-- Coin Selection -->
                <div>
                    <label for="coin-select" class="block text-sm font-medium text-gray-400 mb-2">Select Coin</label>
                    <select id="coin-select" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none transition-colors duration-200">
                        <option value="USDT">USDT - Tether</option>
                        <option value="BTC">BTC - Bitcoin</option>
                        <option value="ETH">ETH - Ethereum</option>
                      <option value="SOL">SOL - SOLANA</option>
                    </select>
                </div>

                <!-- Network Selection -->
                <div>
                    <label for="network-select" class="block text-sm font-medium text-gray-400 mb-2">Select Network</label>
                    <select id="network-select" class="w-full bg-[#2c2e32] text-white rounded-lg p-3 border-none focus:ring-1 focus:ring-green-500 focus:outline-none transition-colors duration-200">
                        
                        <option value="ERC20">ERC20</option>
                        <option value="BEP20">BEP20</option>
                      	<option value="SOLANA">SOLANA</option>
                    </select>
                </div>

                <!-- Deposit Address & QR Code -->
                <div class="text-center">
                    <p class="text-gray-400 text-sm mb-2">Scan QR code to deposit</p>
                    <div id="qr-code-container" class="">
                        <img class="mx-auto rounded-lg mb-4 border border-gray-700/50 p-2 bg-white w-40 h-40 flex items-center justify-center" id="qr-code-url" src="" alt="">
                    </div>
                    
                    <div class="bg-[#2c2e32] rounded-lg p-3 flex items-center justify-between relative">
                        <span id="deposit-address" class="text-sm text-white truncate w-full"></span>
                        <button id="copy-button" class="ml-2 p-1 rounded-full hover:bg-gray-700 focus:outline-none transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v-1a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2h-8a2 2 0 01-2-2v-1m-5-8h5m-5 0h.01M10 13h5m-5 0h.01M10 17h5m-5 0h.01" />
                            </svg>
                        </button>
                        <div id="copy-message" class="absolute top-[-35px] left-1/2 -translate-x-1/2 bg-green-500 text-white text-xs px-2 py-1 rounded-full opacity-0 transition-opacity duration-300">
                            Copied!
                        </div>
                    </div>
                </div>

                <!-- Warning -->
                <div class="bg-yellow-900/30 text-yellow-300 rounded-lg p-4 text-sm mt-4">
                    <p class="font-bold mb-1">Warning:</p>
                    <p id="warning-text"></p>
                </div>
            </div>

            <!-- Deposit History Section -->
            <div class="mt-8">
            <h2 class="text-2xl font-extrabold mb-4 text-white border-b-2 border-green-500 pb-2">Deposit History</h2>

            <!-- Table Container for overflow on smaller screens -->
            <div class="overflow-x-auto rounded-xl shadow-2xl">
                <table class="min-w-full divide-y divide-gray-700/50 bg-[#1f2125]">

                    <!-- Table Header -->
                    <thead class="bg-[#2a2d33] text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">
                                Coin
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body with PHP Loop -->
                    <tbody class="divide-y divide-gray-700/50">
                        <?php
                        // Placeholder variables/logic for demonstration.
                        // In a real application, $conn and $user would be defined globally.
                        $depoid = $user['id'];
                        $desql = "SELECT * FROM payments WHERE client_id = '$depoid' ORDER BY created_at DESC";
                        $dequery = mysqli_query($conn, $desql);

                        // Helper function to dynamically apply status color (optional but recommended)
                        function get_status_class($status) {
                            switch (strtolower($status)) {
                                case 'completed':
                                    return 'text-green-500';
                                case 'pending':
                                    return 'text-yellow-500';
                                case 'failed':
                                    return 'text-red-500';
                                default:
                                    return 'text-gray-400';
                            }
                        }

                        while($deposit = mysqli_fetch_array($dequery)){
                        ?>
                        <tr class="hover:bg-[#25282e] transition duration-150 ease-in-out">
                            <!-- Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">
                                <?php echo $deposit['created_at']; ?>
                            </td>

                            <!-- Coin -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                <?php echo $deposit['coin']; ?>
                            </td>

                            <!-- Amount -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white text-right font-mono">
                                <?php echo number_format($deposit['amount'], 8); ?>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                <span class="font-bold <?php echo get_status_class($deposit['status']); ?>">
                                    <?php echo $deposit['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        </div>
        </main>
        
       <?php include('navbar.php'); ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.flex.items-center.space-x-4 button');
        
        // Select all tab buttons, including deposit-tab2.
        const allTabs = document.querySelectorAll('button[id$="-tab"], #deposit-tab2');

        const spotContent = document.getElementById('spot-content');
        const futuresContent = document.getElementById('futures-content');
        const newListingContent = document.getElementById('new-listing-content');
        const depositContent = document.getElementById('deposit-content');
        const hideZeroCheckbox = document.getElementById('hideZero');
        const copyButton = document.getElementById('copy-button');
        const copyMessage = document.getElementById('copy-message');
        const depositAddressSpan = document.getElementById('deposit-address');
        const deposit_tab2 = document.getElementById("deposit-tab2");
        const allContent = [spotContent, futuresContent, newListingContent, depositContent];
	
                // Function to get a parameter from the URL
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

// --- Execution on Page Load ---
window.onload = function() {
    var requestedPage = getUrlParameter('page');
    
    // Define the default tab ID
    var initialTabId = 'spot-tab'; // Default if no parameter is found
    
    // Check if the 'page' parameter is 'deposit'
    if (requestedPage === 'deposit') {
        // Set the tab ID for the deposit tab
        // Use the ID of the Deposit tab you want to be active by default
        initialTabId = 'deposit-tab'; 
    } else if (requestedPage === 'trade') {
        // Set the tab ID for the deposit tab
        // Use the ID of the Deposit tab you want to be active by default
        initialTabId = 'futures-tab'; 
    } 
    // You could add other checks here:
    // else if (requestedPage === 'futures') {
    //     initialTabId = 'futures-tab';
    // }
    
    // Call your tab switching function with the determined ID
    showTab(initialTabId); 
};
        function showTab(tabId) {
            // Hide all content sections
            allContent.forEach(content => content.classList.add('hidden'));

            // Remove active classes from all tabs
            allTabs.forEach(tab => {
                tab.classList.remove('text-white', 'border-b-2', 'border-green-500', 'font-semibold');
                tab.classList.add('text-gray-400');
            });

            // Show the selected content and activate the tab
            let contentToShow;
            let tabToActivate;

            switch(tabId) {
                case 'spot-tab':
                    contentToShow = spotContent;
                    tabToActivate = document.getElementById('spot-tab');
                    break;
                case 'futures-tab':
                    contentToShow = futuresContent;
                    tabToActivate = document.getElementById('futures-tab');
                    break;
                case 'new-listing-tab':
                    contentToShow = newListingContent;
                    tabToActivate = document.getElementById('new-listing-tab');
                    break;
                case 'deposit-tab':
                    contentToShow = depositContent;
                    tabToActivate = document.getElementById('deposit-tab');
                    break;
                case 'deposit-tab2':
                    // Corrected logic: now activates deposit-tab2 itself
                    contentToShow = depositContent;
                    tabToActivate = deposit_tab2;
                    break;
            }

            if (contentToShow && tabToActivate) {
                contentToShow.classList.remove('hidden');
                tabToActivate.classList.remove('text-gray-400');
                tabToActivate.classList.add('text-white', 'border-b-2', 'border-green-500', 'font-semibold');
            }
        }
        
        // Function to handle showing/hiding assets
        function toggleZeroBalanceAssets() {
            const assetItems = document.querySelectorAll('.asset-item');
            assetItems.forEach(item => {
                const balanceElement = item.querySelector('.asset-balance');
                if (balanceElement && balanceElement.textContent.trim() === '0.00000000') {
                    if (hideZeroCheckbox.checked) {
                        item.classList.add('hidden');
                    } else {
                        item.classList.remove('hidden');
                    }
                }
            });
        }

        // Function to copy text to clipboard
        function copyToClipboard(text) {
            const tempInput = document.createElement('textarea');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }


        // Add click listeners to all tab buttons
        allTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                showTab(tab.id);
            });
        });

        // Initially show the Spot Account content
        showTab('spot-tab');
    });

    </script>
    <script>
            // --- COIN TAPPER & TIMER LOGIC ---
            const coin = document.getElementById('coin-container');
            const tapsDisplay = document.getElementById('taps');
            const countdownDisplay = document.getElementById('countdown-timer');
            let taps = 0;

            // Tapping logic
            coin.addEventListener('click', (event) => {
                taps++;
                tapsDisplay.textContent = taps;
                createTapEffect(event);
            });

            // Add a tap effect (like a number popping up)
            function createTapEffect(event) {
                const effect = document.createElement('div');
                effect.textContent = '+1';
                effect.className = 'tap-effect';
                
                // Position the effect where the tap occurred
                effect.style.left = `${event.clientX}px`;
                effect.style.top = `${event.clientY}px`;

                document.body.appendChild(effect);
                
                // Remove the element after the animation finishes
                setTimeout(() => {
                    effect.remove();
                }, 500);
            }

            // Timer Logic
            // ** IMPORTANT: Set your token listing date here! **
            // The format is 'Month Day, Year HH:MM:SS GMT+00:00'
            // Example: 'January 1, 2026 12:00:00 GMT+00:00'
            const listingDate = new Date('October 20, 2025 10:00:00 GMT+00:00').getTime();

            const timer = setInterval(() => {
                const now = new Date().getTime();
                const distance = listingDate - now;

                if (distance < 0) {
                    clearInterval(timer);
                    countdownDisplay.innerHTML = "🎉 **LISTED!**";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownDisplay.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }, 1000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
    <script>
        // Data object to hold all deposit info
        const depositData = {
            'USDT': {
                'ERC20': {
                    address: '<?php echo $USDTfetch['address']; ?>',
                    qrcode: '<?php echo $USDTfetch['qrcode']; ?>',
                    qrText: 'ERC20:<?php echo $USDTfetch['address']; ?>',
                    warning: 'Only send USDT on the ERC20 network to this address. Sending other coins or using a different network may result in permanent loss of funds.'
                },
            },
            'BTC': {
                'Bitcoin': {
                    address: '<?php echo $BTCfetch['address']; ?>',
                    qrcode: '<?php echo $BTCfetch['qrcode']; ?>',
                    qrText: 'Bitcoin:<?php echo $BTCfetch['address']; ?>',
                    warning: 'Only send BTC (Bitcoin) to this address. Sending other coins may result in permanent loss of funds.'
                }
            },
            'ETH': {
                'Ethereum': {
                    address: '<?php echo $ETHfetch['address']; ?>',
                    qrcode: '<?php echo $ETHfetch['qrcode']; ?>',
                    qrText: 'ethereum:<?php echo $ETHfetch['address']; ?>',
                    warning: 'Only send ETH (Ethereum) to this address. Sending other coins may result in permanent loss of funds.'
                }
            },
          'SOL': {
                'Solana': {
                    address: '<?php echo $SOLfetch['address']; ?>',
                    qrcode: '<?php echo $SOLfetch['qrcode']; ?>',
                    qrText: 'solana:<?php echo $SOLfetch['address']; ?>',
                    warning: 'Only send SOL (Solana) to this address. Sending other coins may result in permanent loss of funds.'
                }
            }
        };

        // Get DOM elements
        const coinSelect = document.getElementById('coin-select');
        const networkSelect = document.getElementById('network-select');
        const depositAddressSpan = document.getElementById('deposit-address');
        const warningText = document.getElementById('warning-text');
        const copyButton = document.getElementById('copy-button');
        const copyMessage = document.getElementById('copy-message');
        //const qrCodeContainer = document.getElementById('qr-code-container');
        const qrCodeurl = document.getElementById('qr-code-url');

        // Initialize QR code generator
        const qrCode = new QRious({
            element: document.createElement('canvas'),
            size: 150,
        });
        //qrCodeContainer.appendChild(qrCode.element);

        // Function to update the deposit information
        function updateDepositInfo() {
            const selectedCoin = coinSelect.value;
            const selectedNetwork = networkSelect.value;

            // Handle network options
            const networks = Object.keys(depositData[selectedCoin]);
            networkSelect.innerHTML = ''; // Clear existing options
            networks.forEach(network => {
                const option = document.createElement('option');
                option.value = network;
                option.textContent = network;
                networkSelect.appendChild(option);
            });

            // Get the selected network after options are updated
            const currentNetwork = networkSelect.value;

            // Get the data for the current selection
            const data = depositData[selectedCoin][currentNetwork];

            // Update the UI
            depositAddressSpan.textContent = data.address;
            warningText.textContent = data.warning;

            // Update the UI
            qrCodeurl.src = "../../address/"+data.qrcode;
           
            
            
            // Update the QR code
            //qrCode.value = data.qrText;
        }

        // Function to handle the copy action
        function copyAddress() {
            const address = depositAddressSpan.textContent;
            const tempInput = document.createElement('input');
            tempInput.value = address;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            // Show a "Copied!" message
            copyMessage.classList.remove('opacity-0');
            copyMessage.classList.add('opacity-100');
            setTimeout(() => {
                copyMessage.classList.remove('opacity-100');
                copyMessage.classList.add('opacity-0');
            }, 1500);
        }

        // Add event listeners
        coinSelect.addEventListener('change', updateDepositInfo);
        networkSelect.addEventListener('change', updateDepositInfo);
        copyButton.addEventListener('click', copyAddress);

        // Initial setup on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateDepositInfo();
        });
    </script>
   <script src="js/topNavFooter.js"></script>
</body>
</html>
