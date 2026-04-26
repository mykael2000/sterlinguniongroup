<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Crypto Tracker</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Inter Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js Date Adapter -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.4.4/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.3.1/dist/chartjs-adapter-luxon.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #1a202c; /* dark background */
        }
        .modal-content-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        @media (min-width: 640px) {
            .modal-content-container {
                grid-template-columns: 1fr 1fr;
            }
        }
        .tab-btn {
            @apply py-2 px-4 rounded-full font-semibold text-sm transition-colors duration-200;
        }
        .tab-btn.active {
            @apply bg-indigo-600 text-white shadow-md;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 flex flex-col items-center min-h-screen p-4">

    <script>
        const userId = 'user-' + Math.random().toString(36).substring(2, 8);
        let currentCoin = null;
        let myChart = null;

        let liveCoinData = [];
        const tradeData = {};
        
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('coin-modal');
            const tradeForm = document.getElementById('trade-form');
            const userIdDisplay = document.getElementById('user-id-display');
            const mainContent = document.getElementById('main-content');
            const tabButtons = document.querySelectorAll('.tab-btn');

            userIdDisplay.textContent = `Your ID: ${userId}`;
            mainContent.classList.remove('hidden');

            // Fetches all the data and renders the table for a given category
            const fetchAndRenderCoins = async (category) => {
                const loadingElement = document.getElementById('loading-state');
                const lastUpdatedElement = document.getElementById('last-updated');
                const tableBody = document.getElementById('coins-table-body');
                
                loadingElement.classList.remove('hidden');
                tableBody.innerHTML = '';
                
                try {
                    const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1&sparkline=false&price_change_percentage=24h');
                    if (!response.ok) {
                        throw new Error('Failed to fetch data from API.');
                    }
                    liveCoinData = await response.json();

                    // Sort or filter based on category
                    let dataToRender = [...liveCoinData];
                    if (category === 'gainers') {
                        dataToRender.sort((a, b) => b.price_change_percentage_24h - a.price_change_percentage_24h);
                    } else if (category === 'losers') {
                        dataToRender.sort((a, b) => a.price_change_percentage_24h - b.price_change_percentage_24h);
                    }
                    // Limiting to top 10 for display
                    renderTable(dataToRender.slice(0, 10));

                    const now = new Date();
                    lastUpdatedElement.textContent = `Last updated: ${now.toLocaleTimeString()}`;
                } catch (error) {
                    console.error("Error fetching data:", error);
                    tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-400">Failed to load data. Please try again later.</td></tr>`;
                } finally {
                    loadingElement.classList.add('hidden');
                }
            };
            
            // Initial render and setup for periodic refresh
            fetchAndRenderCoins('market_cap');
            setInterval(() => fetchAndRenderCoins(document.querySelector('.tab-btn.active').dataset.category), 30000);

            // Handles the display of the coin details modal
            function showModal(coin) {
                currentCoin = coin;
                modal.classList.remove('hidden');
                document.getElementById('coin-modal-name').textContent = coin.name;
                document.getElementById('coin-modal-price').textContent = `$${coin.current_price.toLocaleString()}`;
                document.getElementById('trading-coin-name').textContent = coin.name;
                
                // Set the default chart to 24 hours
                document.querySelector('[data-days="1"]').click();
            }

            // Handles closing the modal
            function closeModal() {
                modal.classList.add('hidden');
                if (myChart) {
                    myChart.destroy();
                    myChart = null;
                }
                document.getElementById('amount-input').value = '';
                document.getElementById('price-input').value = '';
            }
            
            // Renders the main table with coin data
            function renderTable(coins) {
                const tableBody = document.getElementById('coins-table-body');
                tableBody.innerHTML = '';
                
                coins.forEach((coin, index) => {
                    const isPositive = parseFloat(coin.price_change_percentage_24h) >= 0;
                    const changeColor = isPositive ? 'text-green-400' : 'text-red-400';
                    const arrowIcon = isPositive ? 'fa-arrow-up' : 'fa-arrow-down';
                    
                    const rowHtml = `
                        <tr class="border-b border-gray-700 hover:bg-gray-800 transition-colors duration-200 cursor-pointer" data-coin-id="${coin.id}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">${index + 1}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <img src="${coin.image}" alt="${coin.name} logo" class="w-6 h-6 rounded-full">
                                    <span class="font-medium text-white">${coin.name}</span>
                                    <span class="text-gray-400 text-xs">${coin.symbol.toUpperCase()}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg font-semibold text-white">$${coin.current_price.toLocaleString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm ${changeColor}">
                                <i class="fa-solid ${arrowIcon} mr-1"></i>${coin.price_change_percentage_24h.toFixed(2)}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="trade-button py-2 px-4 rounded-full bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200 text-white shadow-md">Trade</button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += rowHtml;
                });

                document.querySelectorAll('.trade-button').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const coinRow = e.target.closest('tr');
                        const coinId = coinRow.dataset.coinId;
                        const selectedCoin = liveCoinData.find(c => c.id === coinId);
                        if (selectedCoin) {
                            showModal(selectedCoin);
                        }
                    });
                });
            }
            
            // Handles form submission for placing a trade
            tradeForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const amountInput = document.getElementById('amount-input');
                const priceInput = document.getElementById('price-input');
                const type = e.submitter.dataset.type;
                
                const amount = parseFloat(amountInput.value);
                const price = parseFloat(priceInput.value);
                
                if (isNaN(amount) || isNaN(price) || amount <= 0 || price <= 0) {
                     const messageElement = document.getElementById('trade-message');
                     messageElement.textContent = "Please enter a valid amount and price.";
                     messageElement.className = 'mt-4 text-center font-semibold text-red-400';
                    return;
                }

                if (currentCoin && userId) {
                    if (!tradeData[currentCoin.id]) {
                        tradeData[currentCoin.id] = [];
                    }
                    tradeData[currentCoin.id].push({ userId: userId, type: type, amount: amount, price: price });
                    
                    const messageElement = document.getElementById('trade-message');
                    messageElement.textContent = `Trade placed successfully: ${type.toUpperCase()} ${amount} ${currentCoin.symbol.toUpperCase()} @ $${price}`;
                    messageElement.className = 'mt-4 text-center font-semibold text-green-400';
                    
                    setTimeout(() => {
                        messageElement.textContent = '';
                    }, 3000);
                    
                    amountInput.value = '';
                    priceInput.value = '';
                }
            });

            // Handles fetching historical chart data
            const getChartData = async (coinId, days) => {
                const chartLoading = document.getElementById('chart-loading-state');
                chartLoading.classList.remove('hidden');
                
                try {
                    const response = await fetch(`https://api.coingecko.com/api/v3/coins/${coinId}/market_chart?vs_currency=usd&days=${days}`);
                    const data = await response.json();
                    
                    if (!data || !data.prices) {
                        throw new Error('No chart data available.');
                    }
                    
                    // Format data for Chart.js
                    const formattedData = data.prices.map(price => ({
                        x: new Date(price[0]),
                        y: price[1]
                    }));

                    return formattedData;
                } catch (error) {
                    console.error("Error fetching chart data:", error);
                    return null;
                } finally {
                    chartLoading.classList.add('hidden');
                }
            };

            // Renders the chart with fetched historical data
            const renderChart = async (coinId, days) => {
                const chartCanvas = document.getElementById('price-chart');
                const chartData = await getChartData(coinId, days);
                
                if (!chartData) {
                    console.error("Could not render chart due to lack of data.");
                    return;
                }

                if (myChart) {
                    myChart.destroy();
                }

                myChart = new Chart(chartCanvas, {
                    type: 'line',
                    data: {
                        datasets: [{
                            label: 'Price (USD)',
                            data: chartData,
                            borderColor: '#818cf8',
                            backgroundColor: 'rgba(129, 140, 248, 0.2)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: days === '1' ? 'hour' : 'day',
                                    tooltipFormat: 'MMM D, h:mm a'
                                },
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#d1d5db'
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.2)'
                                },
                                ticks: {
                                    color: '#d1d5db'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    title: function(context) {
                                        return new Date(context[0].parsed.x).toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            };

            // Event listeners for tabs and modal
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    const category = button.dataset.category;
                    fetchAndRenderCoins(category);
                });
            });

            document.getElementById('close-modal').addEventListener('click', closeModal);
            document.getElementById('backdrop').addEventListener('click', closeModal);
            document.querySelectorAll('.chart-range-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    document.querySelectorAll('.chart-range-btn').forEach(btn => btn.classList.remove('active'));
                    e.target.classList.add('active');
                    renderChart(currentCoin.id, e.target.dataset.days);
                });
            });
        });
    </script>

    <div id="main-content" class="w-full">
        <!-- Navigation Bar -->
        <nav class="w-full bg-gray-900 shadow-md mb-8 py-4 px-6 fixed top-0 left-0 right-0 z-50">
            <div class="flex items-center justify-end">
                <div class="space-x-6 text-sm font-medium">
                    <a href="#" class="text-gray-300 hover:text-indigo-400 transition-colors duration-200">
                        <i class="fa-solid fa-user-circle mr-2"></i>Profile Settings
                    </a>
                    <a href="#" class="text-gray-300 hover:text-indigo-400 transition-colors duration-200">
                        <i class="fa-solid fa-shield-alt mr-2"></i>Security Settings
                    </a>
                    <a href="#" class="text-gray-300 hover:text-indigo-400 transition-colors duration-200">
                        <i class="fa-solid fa-arrow-up mr-2"></i>Account Upgrade
                    </a>
                </div>
            </div>
        </nav>

        <div class="w-full max-w-4xl mx-auto text-center mt-24 mb-8">
            <h1 class="text-4xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-600">Crypto Dashboard</h1>
            <p class="text-gray-400">Tap on a coin to view details, chart, and place a trade.</p>
            <p id="user-id-display" class="text-xs text-gray-500 mt-2"></p>
        </div>
        
        <!-- Tab Navigation for Categories -->
        <div class="w-full max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0">
            <div class="flex space-x-2 bg-gray-800 p-1 rounded-full shadow-lg">
                <button data-category="market_cap" class="tab-btn active">Top 10</button>
                <button data-category="hot" class="tab-btn">Hot</button>
                <button data-category="gainers" class="tab-btn">Gainers</button>
                <button data-category="losers" class="tab-btn">Losers</button>
            </div>
            <p id="last-updated" class="text-xs text-gray-500"></p>
        </div>

        <!-- Main Content Table -->
        <div class="w-full max-w-7xl mx-auto overflow-x-auto rounded-xl relative">
            <div id="loading-state" class="absolute inset-0 bg-gray-900 bg-opacity-70 flex items-center justify-center rounded-xl z-20 hidden">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-t-4 border-indigo-500 border-gray-700"></div>
            </div>
            <table class="min-w-full divide-y divide-gray-700 bg-gray-800 shadow-lg">
                <thead class="bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tl-xl">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">24h Change</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tr-xl">Actions</th>
                    </tr>
                </thead>
                <tbody id="coins-table-body" class="divide-y divide-gray-700">
                    <!-- Table rows will be dynamically generated by JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- News & Insights Section -->
        <div class="w-full max-w-7xl mx-auto mt-12">
            <h2 class="text-3xl font-bold mb-6 text-center text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-600">Crypto News & Insights</h2>
            <div class="flex flex-col lg:flex-row space-y-6 lg:space-y-0 lg:space-x-6">
                <!-- Latest News Column -->
                <div class="flex-1 bg-gray-800 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-200">Latest News</h3>
                    <div class="space-y-4">
                        <div class="bg-gray-700 p-4 rounded-xl shadow-md transition-shadow duration-200 hover:shadow-lg cursor-pointer">
                            <h4 class="font-bold text-gray-100">Bitcoin Breaks All-Time Highs Again</h4>
                            <p class="text-sm text-gray-400 mt-1">Experts are cautiously optimistic about Bitcoin's momentum, citing institutional adoption and market stability as key drivers.</p>
                            <a href="#" class="text-xs text-indigo-400 hover:underline mt-2 inline-block">Read more &rarr;</a>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-xl shadow-md transition-shadow duration-200 hover:shadow-lg cursor-pointer">
                            <h4 class="font-bold text-gray-100">Ethereum's Latest Upgrade Promises Faster Transactions</h4>
                            <p class="text-sm text-gray-400 mt-1">The new protocol, named 'Serenity,' aims to significantly reduce network congestion and gas fees for all users.</p>
                            <a href="#" class="text-xs text-indigo-400 hover:underline mt-2 inline-block">Read more &rarr;</a>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-xl shadow-md transition-shadow duration-200 hover:shadow-lg cursor-pointer">
                            <h4 class="font-bold text-gray-100">NFT Market Rebounds with a Surge in Volume</h4>
                            <p class="text-sm text-gray-400 mt-1">After a quiet period, the NFT space is seeing renewed interest, particularly in gaming and digital art collectibles.</p>
                            <a href="#" class="text-xs text-indigo-400 hover:underline mt-2 inline-block">Read more &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Market Insights Column -->
                <div class="flex-1 bg-gray-800 rounded-2xl p-6 shadow-xl">
                    <h3 class="text-xl font-semibold mb-4 text-gray-200">Market Insights</h3>
                    <div class="space-y-4">
                        <div class="bg-gray-700 p-4 rounded-xl shadow-md flex items-center space-x-4">
                            <div class="text-yellow-400 text-2xl"><i class="fa-solid fa-fire"></i></div>
                            <div>
                                <h4 class="font-bold text-gray-100">Trending Search: Dogecoin</h4>
                                <p class="text-sm text-gray-400">Retail interest in memecoins is on the rise, with DOGE leading the pack this week.</p>
                            </div>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-xl shadow-md flex items-center space-x-4">
                            <div class="text-purple-400 text-2xl"><i class="fa-solid fa-chart-line"></i></div>
                            <div>
                                <h4 class="font-bold text-gray-100">Volatility Index: Moderate</h4>
                                <p class="text-sm text-gray-400">The overall market is showing steady movements with fewer dramatic price swings.</p>
                            </div>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-xl shadow-md flex items-center space-x-4">
                            <div class="text-green-400 text-2xl"><i class="fa-solid fa-shield-halved"></i></div>
                            <div>
                                <h4 class="font-bold text-gray-100">Investor Sentiment: Bullish</h4>
                                <p class="text-sm text-gray-400">Most analysts and retail traders are feeling optimistic about the market's future.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Coin Details, Chart, and Trading -->
        <div id="coin-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
            <!-- Backdrop -->
            <div id="backdrop" class="fixed inset-0 bg-gray-900 bg-opacity-80 backdrop-blur-sm"></div>

            <!-- Modal Content -->
            <div id="modal-content" class="bg-gray-800 rounded-3xl p-6 sm:p-8 w-full max-w-4xl h-full sm:h-auto max-h-[90vh] relative z-10 shadow-2xl flex flex-col space-y-6 overflow-hidden">
                <!-- Close Button -->
                <button id="close-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-100 transition-colors duration-200 focus:outline-none">
                    <i class="fa-solid fa-times fa-lg"></i>
                </button>
                
                <!-- Details and Trading Column -->
                <div class="modal-content-container">
                    <div class="flex flex-col p-4 sm:p-0">
                        <div class="text-center sm:text-left mb-6">
                            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-600 mb-2" id="coin-modal-name"></h2>
                            <p class="text-lg text-gray-300" id="coin-modal-price"></p>
                        </div>
                        
                        <!-- Chart Area -->
                        <div class="bg-gray-900 rounded-xl p-6 mb-6 shadow-inner flex-grow relative">
                            <h3 class="text-xl font-semibold mb-4 text-center text-gray-200">Price Chart</h3>
                            <div class="absolute inset-0 bg-gray-900 bg-opacity-70 flex items-center justify-center rounded-xl z-20 hidden" id="chart-loading-state">
                                <div class="animate-spin rounded-full h-12 w-12 border-4 border-t-4 border-indigo-500 border-gray-700"></div>
                            </div>
                            <div class="flex justify-center space-x-2 mb-4 text-gray-400 text-xs sm:text-sm">
                                <button data-days="1" class="chart-range-btn active px-3 py-1 rounded-full bg-gray-700 hover:bg-gray-600 transition-colors">24h</button>
                                <button data-days="7" class="chart-range-btn px-3 py-1 rounded-full bg-gray-700 hover:bg-gray-600 transition-colors">7d</button>
                                <button data-days="30" class="chart-range-btn px-3 py-1 rounded-full bg-gray-700 hover:bg-gray-600 transition-colors">30d</button>
                                <button data-days="365" class="chart-range-btn px-3 py-1 rounded-full bg-gray-700 hover:bg-gray-600 transition-colors">1y</button>
                            </div>
                            <div class="h-48">
                                <canvas id="price-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Trading Area -->
                    <div class="flex flex-col p-4 sm:p-0">
                        <div class="bg-gray-900 rounded-xl p-6 shadow-inner flex-grow">
                            <h3 class="text-xl font-semibold mb-4 text-center text-gray-200">Place a Trade for <span id="trading-coin-name" class="font-bold"></span></h3>
                            <form id="trade-form" class="space-y-4">
                                <div>
                                    <label for="amount-input" class="block text-sm font-medium text-gray-400">Amount</label>
                                    <input type="number" id="amount-input" step="0.001" placeholder="e.g., 0.5" class="mt-1 block w-full rounded-lg border-transparent bg-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div>
                                    <label for="price-input" class="block text-sm font-medium text-gray-400">Price (USD)</label>
                                    <input type="number" id="price-input" step="0.01" placeholder="e.g., 68500" class="mt-1 block w-full rounded-lg border-transparent bg-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                </div>
                                <div class="flex space-x-4 pt-2">
                                    <button type="submit" data-type="buy" class="flex-1 py-3 px-4 rounded-xl font-bold text-lg text-white bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-md">Buy</button>
                                    <button type="submit" data-type="sell" class="flex-1 py-3 px-4 rounded-xl font-bold text-lg text-white bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 transition-all duration-300 transform hover:scale-105 shadow-md">Sell</button>
                                </div>
                            </form>
                            <p id="trade-message" class="mt-4 text-center font-semibold"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
