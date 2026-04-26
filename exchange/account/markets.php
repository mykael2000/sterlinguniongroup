<?php
include('connection.php');
include('function.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Dashboard</title>
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
       <nav id="sidebar" class="fixed top-0 right-0 w-full h-full bg-[#121414] border-l border-gray-700/50 z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="p-4 flex flex-col h-full">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img height="30px" width="30px" src="profile.jpg" alt="User Profile" class="rounded-full">
                        <div>
                            <div class="font-bold text-white"><?php echo $user['firstname'].' '.$user['lastname']; ?></div>
                            <div class="text-sm text-gray-400">View Profile</div>
                        </div>
                    </div>
                    <button id="close-menu-btn" class="p-2 rounded-full hover:bg-gray-800 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="mt-8 flex-1 overflow-y-auto no-scrollbar">
                    <ul class="space-y-4 text-gray-300 font-medium">
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="deposit.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>Deposit</span>
                            </a>
                        </li>
                        <li>
                            <a href="withdrawal.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>Withdrawal</span>
                            </a>
                        </li>
                        <li>
                            <a href="history.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>Transaction History</span>
                            </a>
                        </li>
                        <li>
                            <a href="rewards.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>My Rewards</span>
                            </a>
                        </li>
                        <li>
                            <a href="security.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>Security</span>
                            </a>
                        </li>
                        <li>
                            <a href="verification.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>Verification</span>
                            </a>
                        </li>
                        <li>
                            <a href="referral.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>Referral Hub</span>
                            </a>
                        </li>
                        <li>
                            <a href="settings.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mt-auto pt-4 border-t border-gray-700/50 w-full text-center px-4">
                    <a href="logout.php" class="inline-flex items-center justify-center w-full space-x-2 p-2 rounded-lg hover:bg-red-500/20 text-red-400 font-semibold">
                        <span>Log out</span>
                    </a>
                </div>
            </div>
        </nav>
        
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

        <header class="p-4 flex items-center justify-between bg-[#121417] border-b border-gray-700/50">
            <div class="flex items-center space-x-2">
                <a href="profile.php" class="p-2 rounded-full hover:bg-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7A4 4 0 1112 3a4 4 0 014 4zM12 14c-4.418 0-8 3.582-8 8H20c0-4.418-3.582-8-8-8z" />
                    </svg>
                </a>
            </div>
            <div class="flex items-center space-x-2">
                <button class="p-2 rounded-full hover:bg-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <button id="menu-btn" class="p-2 rounded-full hover:bg-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-4 overflow-y-auto no-scrollbar">
          
            
                 <!-- Live Crypto Charts -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-white">Live Charts</h2>
                    <div style="height: 600px" class="container">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container" style="height:100%;width:100%">
                        <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
                        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/BINANCE-BTCUSDT/?exchange=BINANCE" rel="noopener nofollow" target="_blank"><span class="blue-text">BTCUSDT chart by Prime Jarvis</span></a></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                        {
                        "allow_symbol_change": true,
                        "calendar": false,
                        "details": false,
                        "hide_side_toolbar": true,
                        "hide_top_toolbar": false,
                        "hide_legend": false,
                        "hide_volume": false,
                        "hotlist": false,
                        "interval": "D",
                        "locale": "en",
                        "save_image": true,
                        "style": "1",
                        "symbol": "BINANCE:BTCUSDT",
                        "theme": "dark",
                        "timezone": "Etc/UTC",
                        "backgroundColor": "#0F0F0F",
                        "gridColor": "rgba(242, 242, 242, 0.06)",
                        "watchlist": [],
                        "withdateranges": false,
                        "compareSymbols": [],
                        "studies": [],
                        "autosize": true
                        }
                        </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- BTC Chart -->
                        <div class="bg-[#1f2125] rounded-lg p-2 shadow-lg">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/BINANCE-BTCUSDT/?exchange=BINANCE" rel="noopener nofollow" target="_blank"><span class="blue-text">BTCUSDT chart by Prime Jarvis</span></a></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                            {
                            "symbol": "BINANCE:BTCUSDT",
                            "chartOnly": false,
                            "dateRange": "12M",
                            "noTimeScale": false,
                            "colorTheme": "dark",
                            "isTransparent": false,
                            "locale": "en",
                            "width": "100%",
                            "autosize": true,
                            "height": "100%"
                            }
                            </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>

                        <!-- ETH Chart -->
                        <div class="bg-[#1f2125] rounded-lg p-2 shadow-lg">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/BINANCE-ETHUSDT/?exchange=BINANCE" rel="noopener nofollow" target="_blank"><span class="blue-text">ETHUSDT chart by Prime Jarvis</span></a></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                            {
                            "symbol": "BINANCE:ETHUSDT",
                            "chartOnly": false,
                            "dateRange": "12M",
                            "noTimeScale": false,
                            "colorTheme": "dark",
                            "isTransparent": false,
                            "locale": "en",
                            "width": "100%",
                            "autosize": true,
                            "height": "100%"
                            }
                            </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>

                        <!-- SOL Chart -->
                        <div class="bg-[#1f2125] rounded-lg p-2 shadow-lg">
                           <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/BINANCE-SOLUSDT/?exchange=BINANCE" rel="noopener nofollow" target="_blank"><span class="blue-text">SOLUSDT chart by Prime Jarvis</span></a></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                            {
                            "symbol": "BINANCE:SOLUSDT",
                            "chartOnly": false,
                            "dateRange": "12M",
                            "noTimeScale": false,
                            "colorTheme": "dark",
                            "isTransparent": false,
                            "locale": "en",
                            "width": "100%",
                            "autosize": true,
                            "height": "100%"
                            }
                            </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                    </div>
                    <div style="height: 600px" class="container">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/crypto-coins-screener/" rel="noopener nofollow" target="_blank"><span class="blue-text">Cryptocurrency market by Prime Jarvis</span></a></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
                        {
                        "defaultColumn": "overview",
                        "screener_type": "crypto_mkt",
                        "displayCurrency": "USD",
                        "colorTheme": "dark",
                        "isTransparent": false,
                        "locale": "en",
                        "width": "100%",
                        "height": "100%"
                        }
                        </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
        </main>
        
       <?php include('navbar.php'); ?>
    </div>

     <script src="js/topNavFooter.js"></script>
</body>
</html>
