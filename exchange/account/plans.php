<?php
include('connection.php');
include('function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sterling Union GroupDashboard - Plans</title>
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
            
            <div id="plans-content">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold mb-1 text-white">Choose a Plan</h1>
                    <p class="text-sm text-gray-400">Select an investment plan that fits your goals. All plans offer daily returns.</p>
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-bold mb-4 text-white">Investment Plans</h2>
                    <div class="space-y-6">
                        <div class="bg-[#1f2125] rounded-lg p-6 shadow-md border border-gray-700/50">
                            <h3 class="text-xl font-bold text-white mb-2">Basic Plan <span class="text-sm font-normal text-gray-400">- For Casual Traders</span></h3>
                            <p class="text-sm text-gray-400 mb-4">A great starting point for new investors. This plan provides access to basic automated trading tools for beginners.</p>
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div class="text-gray-400">Min. Deposit: <span class="text-white font-semibold">$899</span></div>
                                <div class="text-gray-400">Max. Deposit: <span class="text-white font-semibold">$9,999</span></div>
                                <div class="text-gray-400">Profit Rate: <span class="text-green-500 font-semibold">19%</span></div>
                            </div>
                            <h4 class="text-md font-semibold text-white mb-2">Features:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-400 mb-4">
                                <li>Simple Trading Bots: Execute basic strategies like market orders and stop losses.</li>
                                <li>Limited Pair Options: Access a few crypto pairs or assets.</li>
                                <li>Basic Strategy Customization: Limited options for creating or customizing strategies.</li>
                                <li>Backtesting: Basic backtesting with limited data.</li>
                                <li>Basic Analytics: Access to fundamental performance metrics like win rates.</li>
                            </ul>
                            <h4 class="text-md font-semibold text-white mb-2">Benefits:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-400 mb-4">
                                <li>Low-cost entry for beginners.</li>
                                <li>Access to basic automated trading tools.</li>
                            </ul>
                            <a href="index.php?page=deposit" class="w-full block text-center bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                Invest Now
                            </a>
                        </div>

                        <div class="bg-[#1f2125] rounded-lg p-6 shadow-md border border-gray-700/50">
                            <h3 class="text-xl font-bold text-white mb-2">Standard Plan <span class="text-sm font-normal text-gray-400">- For Active Traders</span></h3>
                            <p class="text-sm text-gray-400 mb-4">Balanced risk and reward for steady growth. Suitable for traders looking for a more advanced, hands-on experience.</p>
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div class="text-gray-400">Min. Deposit: <span class="text-white font-semibold">$10,000</span></div>
                                <div class="text-gray-400">Max. Deposit: <span class="text-white font-semibold">$79,999</span></div>
                                <div class="text-gray-400">Profit Rate: <span class="text-green-500 font-semibold">23%</span></div>
                            </div>
                            <h4 class="text-md font-semibold text-white mb-2">Features:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-400 mb-4">
                                <li>Advanced Bots: More sophisticated bots with additional customization options, like arbitrage or trend-following.</li>
                                <li>Broader Asset Coverage: More crypto pairs, and support for forex or stocks.</li>
                                <li>Wider Parameters: A wider range of parameters and more historical data for backtesting.</li>
                                <li>Strategy Templates: Pre-built templates for various strategies.</li>
                                <li>Performance Analytics: Advanced analytics including drawdown and risk-to-reward ratio.</li>
                                <li>API Access: Ability to integrate with external data sources.</li>
                            </ul>
                            <h4 class="text-md font-semibold text-white mb-2">Benefits:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-400 mb-4">
                                <li>More customization and flexibility for active traders.</li>
                                <li>Access to a broader range of markets and trading pairs.</li>
                            </ul>
                            <a href="index.php?page=deposit" class="w-full block text-center bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                Invest Now
                            </a>
                        </div>
                        
                        <div class="bg-[#1f2125] rounded-lg p-6 shadow-md border border-gray-700/50">
                            <h3 class="text-xl font-bold text-white mb-2">Advanced Plan <span class="text-sm font-normal text-gray-400">- For Sophisticated Traders</span></h3>
                            <p class="text-sm text-gray-400 mb-4">Optimized for experienced investors who need automatic solutions and robust analytics.</p>
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div class="text-gray-400">Min. Deposit: <span class="text-white font-semibold">$80,000</span></div>
                                <div class="text-gray-400">Max. Deposit: <span class="text-white font-semibold">$299,999</span></div>
                                <div class="text-gray-400">Profit Rate: <span class="text-green-500 font-semibold">32%</span></div>
                            </div>
                            <h4 class="text-md font-semibold text-white mb-2">Features:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-400 mb-4">
                                <li>Advanced Bots and Strategies: Highly advanced bots with complex algorithms, including machine learning models.</li>
                                <li>Customizable Algorithms: Full customization of trading algorithms with the ability to code or tweak strategies.</li>
                                <li>Increased Data and Metrics: Access to larger datasets and real-time market depth and on-chain data.</li>
                                <li>Advanced Risk Management: Automatically set stop losses, take profits, and trailing stops with precise controls.</li>
                                <li>Integration with TradingView: Use TradingView alerts and strategies.</li>
                            </ul>
                            <h4 class="text-md font-semibold text-white mb-2">Benefits:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-400 mb-4">
                                <li>Access to the most advanced bot features and algorithms.</li>
                                <li>Tailored risk management and optimization tools.</li>
                            </ul>
                            <a href="index.php?page=deposit" class="w-full block text-center bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                Invest Now
                            </a>
                        </div>
                        
                        <div class="bg-[#1f2125] rounded-lg p-6 shadow-md border border-gray-700/50">
                            <h3 class="text-xl font-bold text-white mb-2">Elite Plan <span class="text-sm font-normal text-gray-400">- For High-Volume Traders</span></h3>
                            <p class="text-sm text-gray-400 mb-4">Exclusive access for high-volume traders and individuals managing large capital.</p>
                            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                <div class="text-gray-400">Min. Deposit: <span class="text-white font-semibold">$300,000</span></div>
                                <div class="text-gray-400">Max. Deposit: <span class="text-white font-semibold">$6,000,000</span></div>
                                <div class="text-gray-400">Profit Rate: <span class="text-green-500 font-semibold">42%</span></div>
                            </div>
                            <h4 class="text-md font-semibold text-white mb-2">Features:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-400 mb-4">
                                <li>Institutional-Grade Bots: Bots designed for high-frequency trading and large-scale operations.</li>
                                <li>Custom Bot Development: Build custom bots from scratch with expert support.</li>
                                <li>Comprehensive Market Data: Real-time access to massive market data across multiple exchanges.</li>
                                <li>Advanced Portfolio Management: Sophisticated tools for handling multiple accounts or large capital.</li>
                                <li>Dedicated Account Manager: Personalized support for strategy optimization.</li>
                                <li>VIP Features: Priority access to new features and beta releases.</li>
                            </ul>
                            <h4 class="text-md font-semibold text-white mb-2">Benefits:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-400 mb-4">
                                <li>Access to the most advanced features for high-frequency and institutional traders.</li>
                                <li>High-level customization and support.</li>
                            </ul>
                            <a href="index.php?page=deposit" class="w-full block text-center bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                Invest Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <?php include('navbar.php'); ?>
    </div>
    <script src="js/topNavFooter.js"></script>
</body>
</html>