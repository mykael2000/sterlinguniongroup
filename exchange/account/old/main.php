<?php include('header.php'); ?>

            <!-- Page content -->
            <div class="page-content">
                
    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Welcome, <?php  echo $user['firstname'].' '.$user['lastname']; ?>!</h5>
            </div>
        </div>
    </div>
    <div>
    </div>    <div>
    </div>       <!--Portfolio-->
	<div class="row">
        <div class="col-12">
            <div class="p-3 card shadow border">
                <div class="mb-3">
                    <div>
                        <small class="text-muted" style="font-size:0.7rem !important">ACCOUNT BALANCE</small>
                        <h1 class="mt-2 mb-1 text-" style="font-size:2rem !important"><b>$<?php  echo number_format($user['total_balance'], 2, '.', ','); ?></b></h1>
                        <h6 class="mb-1 text- text-muted" style="font-weight:400">
                          <span> BTC <?php echo $user['total_balance']/get_btc_current_price_usd(); ?> </span>
                      </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 pr-md-1 mb-4 mb-md-0 order-md-1 order-2">
                         <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                          <div class="tradingview-widget-container__widget"></div>
                          <div class="tradingview-widget-copyright"><a href="" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on Prime Jarvis</span></a></div>
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
                    <!--Balance and earnings-->
                    <div class="col-md-8 order-1 order-md-2">
                    	<div class="row">
                    	    <div class="col-md-6">
                                <div class="ibox p-2 mb-md-4 mb-3 bg-success color-white widget-stat" style=" !important; border-radius: 10px;">
                                    <div class="ibox-body">
                                                                                                                                <h2 class="mb-0 font-strong" style="font-size: 1.5rem !important">$<?php  echo number_format($user['total_deposits'], 2, '.', ','); ?></h2>
                                                                                                                            <div class="mb-1" style="font-size: 0.8rem !important">TOTAL DEPOSIT</div><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                                                              <path d="M6 9h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H6a4 4 0 0 1-4-4v-1a4 4 0 0 1 4-4z"/>
                                                                                                                              <path d="M10 9V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v3"/>
                                                                                                                              <circle cx="16" cy="14" r="1"/>
                                                                                                                            </svg>

                                        <!--<div><i class="fa fa-level-up mr-1" style="font-size: 0.7rem !important"></i><small>21% higher</small></div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ibox p-2 mb-md-4 mb-3  bg-warning color-white widget-stat" style=" !important; border-radius: 10px;">
                                    <div class="ibox-body">
                                        <h2 class="mb-0 font-strong" style="font-size: 1.5rem !important">$<?php  echo number_format($user['total_profit'], 2, '.', ','); ?></h2>
                                        <div class="mb-1" style="font-size: 0.8rem !important">TOTAL PROFIT</div><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                      <path d="M6 9h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H6a4 4 0 0 1-4-4v-1a4 4 0 0 1 4-4z"/>
                                                      <path d="M10 9V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v3"/>
                                                      <circle cx="16" cy="14" r="1"/>
                                                    </svg>

                                        <!--<div><i class="fa fa-level-up mr-1" style="font-size: 0.7rem !important"></i><small>21% higher</small></div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ibox p-2 mb-md-0 mb-3 bg-secondary color-white widget-stat" style=" !important; border-radius: 10px;">
                                    <div class="ibox-body">
                                        <h2 class="mb-0 font-strong" style="font-size: 1.5rem !important">$<?php  echo number_format($user['total_bonus'], 2, '.', ','); ?></h2>
                                        <div class="mb-1" style="font-size: 0.8rem !important">TOTAL BONUS</div><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                              <path d="M6 9h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H6a4 4 0 0 1-4-4v-1a4 4 0 0 1 4-4z"/>
                                              <path d="M10 9V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v3"/>
                                              <circle cx="16" cy="14" r="1"/>
                                            </svg>

                                        <!--<div><i class="fa fa-level-up mr-1" style="font-size: 0.7rem !important"></i><small>21% higher</small></div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ibox p-2 mb-md-0 mb-3 bg-primary color-white widget-stat" style=" !important; border-radius: 10px;">
                                    <div class="ibox-body">
                                          <h2 class="mb-0 font-strong" style="font-size: 1.5rem !important">$<?php  echo number_format($user['total_withdrawals'], 2, '.', ','); ?></h2> 
                                          <div class="mb-1" style="font-size: 0.8rem !important">TRANSFERS</div><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                          <path d="M6 9h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H6a4 4 0 0 1-4-4v-1a4 4 0 0 1 4-4z"/>
                                          <path d="M10 9V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v3"/>
                                          <circle cx="16" cy="14" r="1"/>
                                          </svg>

                                        <!--<div><i class="fa fa-level-up mr-1" style="font-size: 0.7rem !important"></i><small>21% higher</small></div>-->
                                    </div>
                                </div>
                            </div>
                      </div>
                  </div>
                 
                </div>
            </div>
        </div>
    </div>
    <!---->
    <div class="row p-4">
        <div class="col-4">
            <a href="withdrawals.php">
                <button class="btn btn-danger w-100 py-3 py-sm-2 d-flex flex-column justify-content-center align-items-center">
                    <span class="btn-inner--icon mb-1"> <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 7V4A2 2 0 0 0 14 2H10A2 2 0 0 0 8 4V7"/>
                            <path d="M2 13H22"/>
                        </svg>
                    </span>
                    <span class="small text-nowrap">SEND</span>
                </button>
            </a>
        </div>
        <div class="col-4">
            <a href="deposit.php">
                <button class="btn btn-success w-100 py-3 py-sm-2 d-flex flex-column justify-content-center align-items-center">
                    <span class="btn-inner--icon mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7H17A2 2 0 0 1 19 9V15A2 2 0 0 1 17 17H3V7Z"/>
                            <path d="M19 9H22V15H19" />
                            <circle cx="16" cy="12" r="1"/>
                        </svg>
                    </span>
                    <span class="small text-nowrap">RECEIVE</span>
                </button>
            </a>
        </div>
        <div class="col-4">
            <a href="swap.php">
                <button class="btn btn-warning w-100 py-3 py-sm-2 d-flex flex-column justify-content-center align-items-center">
                    <span class="btn-inner--icon mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                           viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 3h5v5" />
                            <path d="M21 3l-6.5 6.5a4 4 0 0 1-5.6 0L3 3" />
                            <path d="M8 21H3v-5" />
                            <path d="M3 21l6.5-6.5a4 4 0 0 1 5.6 0L21 21" />
                        </svg>
                    </span>
                    <span class="small text-nowrap">SWAP</span>
                </button>
            </a>
        </div>
    </div>
              <!--10 Recent transaction begin-->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="nk-block-head-content mb-4">
                        <h6 class="text-primary h5">Recent Transactions</h6>
                    </div>
                     <div class="tab-content" id="pills-tabContent">
                          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                              <div class="wallet-history">
                                  <?php
                                  $count = 0;
                                  $limit = 10;

                                  while ($trans = mysqli_fetch_assoc($query_fetch) and $count < $limit) {
                                      // Determine transaction type and amount display
                                      $is_credit = ($trans['type'] == 'credit');
                                      $type_class = $is_credit ? 'credit' : 'debit';
                                      $sign = $is_credit ? '+' : '-';
                                  ?>
                                <a href="generate_pdf.php?id=<?php echo htmlspecialchars($trans['tranx_id']); ?>" target="_blank" class="transaction-link">
                                      <div class="transaction-card <?php echo $type_class; ?>">
                                          <div class="icon-container">
                                              <?php if ($is_credit): ?>
                                                  <i class="fa-solid fa-circle-arrow-left transaction-icon"></i>
                                              <?php else: ?>
                                                  <i class="fa-solid fa-circle-arrow-right transaction-icon"></i>
                                              <?php endif; ?>
                                          </div>
                                          <div class="transaction-details">
                                              <div class="transaction-type">
                                                  <?php echo $is_credit ? 'Received' : 'Transfer'; ?>
                                              </div>
                                              <div class="transaction-info">
                                                  <div class="details-text"><?php echo htmlspecialchars($trans['details']); ?></div>
                                                  <div class="fees-text">
                                                      Fees: $<?php echo $trans['fees']; ?>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="transaction-amount-container">
                                            <div class="transaction-amount-coin">
                                                  <?php echo $sign . ' ' . number_format($trans['amount']/get_btc_current_price_usd(), 8, '.', ',') . ' ' . htmlspecialchars($trans['coin']); ?>
                                              </div>
                                              <div class="transaction-amount-dollar">
                                                  <?php echo $sign . ' $' . number_format($trans['amount'], 2, '.', ','); ?>
                                              </div>
                                              
                                          </div>
                                      </div>
                                </a>
                                  <?php
                                      $count++;
                                  }
                                  ?>
                              </div>
                          </div>
                      </div>
                    <div class="mt-3">
                        <a href="accounthistory.php" style="font-size:0.8rem !important">View all transactions<i class="far fa-arrow-right ml-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end of recent transactions-->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <h5 class="text-primary h5 mb-3">Featured Coins & Indices</h5>
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                        {
                            "symbols": [
                                { "proName": "BINANCE:BTCUSDT", "title": "Bitcoin" },
                                { "proName": "BINANCE:ETHUSDT", "title": "Ethereum" },
                                { "proName": "BINANCE:SOLUSDT", "title": "Solana" },
                                { "proName": "BINANCE:DOGEUSDT", "title": "Dogecoin" },
                                { "proName": "BINANCE:XRPUSDT", "title": "XRP" },
                                { "proName": "BINANCE:BNBUSDT", "title": "BNB" },
                                { "proName": "NASDAQ:TSLA", "title": "Tesla" },
                                { "proName": "FOREXCOM:SPXUSD", "title": "S&P 500" },
                                { "proName": "FX_IDC:EURUSD", "title": "EUR/USD" },
                                { "proName": "OANDA:XAUUSD", "title": "Gold" }
                            ],
                            "showSymbolLogo": true,
                            "isTransparent": false,
                            "displayMode": "adaptive",
                            "colorTheme": "dark",
                            "locale": "en"
                        }
                        </script>
                    </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="nk-block-head-content mb-4">
                        <h5 class="text-primary h5">Crypto Market</h5>
                    </div>
                    <ul class="nav nav-pills mb-3" id="crypto-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="hot-tab" data-toggle="pill" href="#hot" role="tab" aria-controls="hot" aria-selected="true">🔥 Hot</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gainers-tab" data-toggle="pill" href="#gainers" role="tab" aria-controls="gainers" aria-selected="false">🚀 Gainers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="losers-tab" data-toggle="pill" href="#losers" role="tab" aria-controls="losers" aria-selected="false">🔻 Losers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="new-tab" data-toggle="pill" href="#new" role="tab" aria-controls="new" aria-selected="false">✨ New Listings</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="crypto-tabs-content">
                        <div class="tab-pane fade show active" id="hot" role="tabpanel" aria-labelledby="hot-tab">
                            <div class="table-responsive">
                                <table class="table table-hover crypto-table">
                                    <thead>
                                        <tr>
                                            <th>Coin</th>
                                            <th>Symbol</th>
                                            <th>Trade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $trending_coins = get_trending_coins();
                                        foreach ($trending_coins as $coin): 
                                            $coin_id = $coin['item']['id'];
                                            $symbol = strtoupper($coin['item']['symbol']);
                                            $name = $coin['item']['name'];
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($name); ?></td>
                                            <td><?php echo htmlspecialchars($symbol); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary trade-btn" data-symbol="<?php echo htmlspecialchars($symbol); ?>" data-coin-id="<?php echo htmlspecialchars($coin_id); ?>">Trade</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="gainers" role="tabpanel" aria-labelledby="gainers-tab">
                            <div class="table-responsive">
                                <table class="table table-hover crypto-table">
                                    <thead>
                                        <tr>
                                            <th>Coin</th>
                                            <th>Price</th>
                                            <th>Change (24h)</th>
                                            <th>Trade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $gainer_loser_data = get_top_gainers_losers('24h');
                                        foreach ($gainer_loser_data['gainers'] as $coin):
                                            $symbol = strtoupper($coin['symbol']);
                                            $change_24h = number_format($coin['price_change_percentage_24h'], 2);
                                            $change_class = $change_24h >= 0 ? 'text-success' : 'text-danger';
                                            $change_sign = $change_24h >= 0 ? '+' : '';
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($coin['name']); ?></td>
                                            <td>$<?php echo number_format($coin['current_price'], 2); ?></td>
                                            <td class="<?php echo $change_class; ?>"><?php echo $change_sign . $change_24h; ?>%</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary trade-btn" data-symbol="<?php echo htmlspecialchars($symbol); ?>" data-coin-id="<?php echo htmlspecialchars($coin['id']); ?>">Trade</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="losers" role="tabpanel" aria-labelledby="losers-tab">
                            <div class="table-responsive">
                                <table class="table table-hover crypto-table">
                                    <thead>
                                        <tr>
                                            <th>Coin</th>
                                            <th>Price</th>
                                            <th>Change (24h)</th>
                                            <th>Trade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $gainer_loser_data = get_top_gainers_losers('24h');
                                        foreach ($gainer_loser_data['losers'] as $coin):
                                            $symbol = strtoupper($coin['symbol']);
                                            $change_24h = number_format($coin['price_change_percentage_24h'], 2);
                                            $change_class = $change_24h >= 0 ? 'text-success' : 'text-danger';
                                            $change_sign = $change_24h >= 0 ? '+' : '';
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($coin['name']); ?></td>
                                            <td>$<?php echo number_format($coin['current_price'], 2); ?></td>
                                            <td class="<?php echo $change_class; ?>"><?php echo $change_sign . $change_24h; ?>%</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary trade-btn" data-symbol="<?php echo htmlspecialchars($symbol); ?>" data-coin-id="<?php echo htmlspecialchars($coin['id']); ?>">Trade</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
                            <div class="table-responsive">
                                <table class="table table-hover crypto-table">
                                    <thead>
                                        <tr>
                                            <th>Coin</th>
                                            <th>Symbol</th>
                                            <th>Trade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $new_listings = get_new_listings();
                                        foreach ($new_listings as $coin): 
                                            $coin_id = $coin['id'];
                                            $symbol = strtoupper($coin['symbol']);
                                            $name = $coin['name'];
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($name); ?></td>
                                            <td><?php echo htmlspecialchars($symbol); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary trade-btn" data-symbol="<?php echo htmlspecialchars($symbol); ?>" data-coin-id="<?php echo htmlspecialchars($coin_id); ?>">Trade</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="row mt-4 d-none" id="trade-view-section">
    <div class="col-12">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="nk-block-head-content mb-4">
                    <h5 class="text-primary h5" id="trade-view-title">Trade BTC</h5>
                </div>
                <div id="chart-container" style="height: 500px;">
                    </div>
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-success mr-2">Buy</button>
                    <button class="btn btn-danger">Sell</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tradeButtons = document.querySelectorAll('.trade-btn');
        const tradeViewSection = document.getElementById('trade-view-section');
        const chartContainer = document.getElementById('chart-container');
        const tradeViewTitle = document.getElementById('trade-view-title');

        function loadTradeView(symbol) {
            tradeViewTitle.innerText = `Trade ${symbol}`;
            tradeViewSection.classList.remove('d-none');
            
            // 1. Clear the container and remove any old script tags
            chartContainer.innerHTML = '';
            
            // 2. Create the main container for the widget
            const tradingViewContainer = document.createElement('div');
            tradingViewContainer.className = 'tradingview-widget-container';
            tradingViewContainer.style.height = '100%';

            // 3. Create the placeholder div for the chart
            const chartPlaceholder = document.createElement('div');
            chartPlaceholder.id = 'tradingview_chart_placeholder';
            chartPlaceholder.style.height = '100%';

            tradingViewContainer.appendChild(chartPlaceholder);
            chartContainer.appendChild(tradingViewContainer);

            // 4. Create and append the TradingView main script
            const script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://s3.tradingview.com/tv.js';
            script.async = true;

            // 5. This is the crucial part: Wait for the main script to load
            script.onload = () => {
                // Now that tv.js is loaded, create the widget instance
                if (typeof TradingView !== 'undefined' && TradingView.widget) {
                    new TradingView.widget(
                        {
                            "autosize": true,
                            "symbol": `BINANCE:${symbol}USDT`, // Use a specific exchange and base pair
                            "interval": "D",
                            "timezone": "Etc/UTC",
                            "theme": "dark",
                            "style": "1",
                            "locale": "en",
                            "toolbar_bg": "#f1f3f6",
                            "enable_publishing": false,
                            "withdateranges": true,
                            "range": "1M",
                            "allow_symbol_change": true,
                            "container_id": "tradingview_chart_placeholder"
                        }
                    );
                }
            };

            // 6. Append the script to the chart container
            chartContainer.appendChild(script);
        }

        tradeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const symbol = this.getAttribute('data-symbol');
                loadTradeView(symbol);
                tradeViewSection.scrollIntoView({ behavior: 'smooth' });
            });
        });
    });
</script>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <h5 class="text-primary h5 mb-3">Bitcoin Chart</h5>
                    <div class="tradingview-widget-container">
                        <div id="tradingview_1a2c3d4e5f" style="height: 450px;"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                        <script type="text/javascript">
                            new TradingView.widget(
                            {
                                "autosize": true,
                                "symbol": "BINANCE:BTCUSDT",
                                "interval": "D",
                                "timezone": "Etc/UTC",
                                "theme": "dark",
                                "style": "1",
                                "locale": "en",
                                "toolbar_bg": "#f1f3f6",
                                "enable_publishing": false,
                                "withdateranges": true,
                                "range": "1M",
                                "hide_side_toolbar": false,
                                "allow_symbol_change": true,
                                "container_id": "tradingview_1a2c3d4e5f"
                            });
                        </script>
                    </div>
                    </div>
            </div>
        </div>
    </div>
     <!--Tesla Chart-->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                      <div class="tradingview-widget-container__widget"></div>
                      <div class="tradingview-widget-copyright"><a href="" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on Prime Jarvis</span></a></div>
                      <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                      {
                      "symbols": [
                        {
                          "proName": "FOREXCOM:SPXUSD",
                          "title": "S&P 500 Index"
                        },
                        {
                          "proName": "FOREXCOM:NSXUSD",
                          "title": "US 100 Cash CFD"
                        },
                        {
                          "proName": "FX_IDC:EURUSD",
                          "title": "EUR to USD"
                        },
                        {
                          "proName": "BITSTAMP:BTCUSD",
                          "title": "Bitcoin"
                        },
                        {
                          "proName": "BITSTAMP:ETHUSD",
                          "title": "Ethereum"
                        },
                        {
                          "proName": "OANDA:XAUUSD",
                          "title": "GOLD"
                        },
                        {
                          "proName": "BINANCE:SOLUSDT",
                          "title": "Solana"
                        },
                        {
                          "proName": "BYBIT:LTCUSDT",
                          "title": "Litecoin"
                        },
                        {
                          "proName": "BINANCE:DOGEUSDT",
                          "title": "Dogecoin"
                        }
                      ],
                      "colorTheme": "dark",
                      "locale": "en",
                      "largeChartUrl": "",
                      "isTransparent": false,
                      "showSymbolLogo": true,
                      "displayMode": "adaptive"
                    }
                      </script>
                    </div>
                    <!-- TradingView Widget END -->
              	</div>
            </div>
        </div>
         <div class="col-6">
              <!-- TradingView Widget BEGIN -->
              <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <div class="tradingview-widget-copyright"><a href="" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on Prime Jarvis</span></a></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                "symbol": "BITSTAMP:ETHUSD",
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
     	 <div class="col-6">
              <!-- TradingView Widget BEGIN -->
              <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <div class="tradingview-widget-copyright"><a href="" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on Prime Jarvis</span></a></div>
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
    <!---->
    <!--Active investments-->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                      <div class="tradingview-widget-container__widget"></div>
                      <div class="tradingview-widget-copyright"><a href="" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on Prime Jarvis</span></a></div>
                      <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
                      {
                      "colorTheme": "dark",
                      "dateRange": "12M",
                      "locale": "en",
                      "largeChartUrl": "",
                      "isTransparent": false,
                      "showFloatingTooltip": false,
                      "plotLineColorGrowing": "rgba(41, 98, 255, 1)",
                      "plotLineColorFalling": "rgba(41, 98, 255, 1)",
                      "gridLineColor": "rgba(240, 243, 250, 0)",
                      "scaleFontColor": "#DBDBDB",
                      "belowLineFillColorGrowing": "rgba(41, 98, 255, 0.12)",
                      "belowLineFillColorFalling": "rgba(41, 98, 255, 0.12)",
                      "belowLineFillColorGrowingBottom": "rgba(41, 98, 255, 0)",
                      "belowLineFillColorFallingBottom": "rgba(41, 98, 255, 0)",
                      "symbolActiveColor": "rgba(41, 98, 255, 0.12)",
                      "tabs": [
                        {
                          "title": "Forex",
                          "symbols": [
                            {
                              "s": "BINANCE:BTCUSDT",
                              "d": "BTCUSDT",
                              "base-currency-logoid": "crypto/XTVCBTC",
                              "currency-logoid": "crypto/XTVCUSDT"
                            },
                            {
                              "s": "BINANCE:ETHUSDT",
                              "d": "ETHUSDT",
                              "base-currency-logoid": "crypto/XTVCETH",
                              "currency-logoid": "crypto/XTVCUSDT"
                            },
                            {
                              "s": "BINANCE:LTCUSDT",
                              "d": "LTCUSDT",
                              "base-currency-logoid": "crypto/XTVCLTC",
                              "currency-logoid": "crypto/XTVCUSDT"
                            },
                            {
                              "s": "OANDA:XAUUSD",
                              "d": "XAUUSD",
                              "logoid": "metal/gold",
                              "currency-logoid": "country/US"
                            },
                            {
                              "s": "OANDA:EURUSD",
                              "d": "EURUSD",
                              "base-currency-logoid": "country/EU",
                              "currency-logoid": "country/US"
                            },
                            {
                              "s": "NASDAQ:TSLA",
                              "d": "TSLA",
                              "logoid": "tesla",
                              "currency-logoid": "country/US"
                            },
                            {
                              "s": "AMEX:SPY",
                              "d": "SPY",
                              "logoid": "spdr-sandp500-etf-tr",
                              "currency-logoid": "country/US"
                            },
                            {
                              "s": "FX:GBPUSD",
                              "d": "GBPUSD",
                              "base-currency-logoid": "country/GB",
                              "currency-logoid": "country/US"
                            },
                            {
                              "s": "FX:USDJPY",
                              "d": "USDJPY",
                              "base-currency-logoid": "country/US",
                              "currency-logoid": "country/JP"
                            }
                          ],
                          "originalTitle": "Forex"
                        },
                        {
                          "title": "Indices",
                          "symbols": [
                            {
                              "s": "FOREXCOM:SPXUSD",
                              "d": "S&P 500 Index"
                            },
                            {
                              "s": "FOREXCOM:NSXUSD",
                              "d": "US 100 Cash CFD"
                            },
                            {
                              "s": "FOREXCOM:DJI",
                              "d": "Dow Jones Industrial Average Index"
                            },
                            {
                              "s": "INDEX:NKY",
                              "d": "Japan 225"
                            },
                            {
                              "s": "INDEX:DEU40",
                              "d": "DAX Index"
                            },
                            {
                              "s": "FOREXCOM:UKXGBP",
                              "d": "FTSE 100 Index"
                            }
                          ],
                          "originalTitle": "Indices"
                        },
                        {
                          "title": "Futures",
                          "symbols": [
                            {
                              "s": "BMFBOVESPA:ISP1!",
                              "d": "S&P 500"
                            },
                            {
                              "s": "BMFBOVESPA:EUR1!",
                              "d": "Euro"
                            },
                            {
                              "s": "CMCMARKETS:GOLD",
                              "d": "Gold"
                            },
                            {
                              "s": "PYTH:WTI3!",
                              "d": "WTI Crude Oil"
                            },
                            {
                              "s": "BMFBOVESPA:CCM1!",
                              "d": "Corn"
                            }
                          ],
                          "originalTitle": "Futures"
                        },
                        {
                          "title": "Bonds",
                          "symbols": [
                            {
                              "s": "EUREX:FGBL1!",
                              "d": "Euro Bund"
                            },
                            {
                              "s": "EUREX:FBTP1!",
                              "d": "Euro BTP"
                            },
                            {
                              "s": "EUREX:FGBM1!",
                              "d": "Euro BOBL"
                            }
                          ],
                          "originalTitle": "Bonds"
                        }
                      ],
                      "support_host": "https://www.tradingview.com",
                      "backgroundColor": "#131722",
                      "width": "100%",
                      "height": "550",
                      "showSymbolLogo": true,
                      "showChart": true
                    }
                      </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            </div>
        </div>
    </div>
    <!---->
    
    
    
    <!--Crypto-->
	<div class="row">
        <div class="col-sm-6 col-lg-6">
            <div class="p-3 card shadow-none border">
                <div class="row p-2">
                    <div class="col-12 p-0">
                        <div class="nk-block-head-content">
                            <h5 class="text-primary h5 mb-3">Market Overview</h5>
                        </div>
                    </div>
                    <div class="col-12 border rounded">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                          <div class="tradingview-widget-container__widget"></div>
                          <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
                          {
                          "colorTheme": "dark",
                          "dateRange": "12M",
                          "showChart": false,
                          "locale": "en",
                          "largeChartUrl": "",
                          "isTransparent": true,
                          "showSymbolLogo": true,
                          "showFloatingTooltip": false,
                          "width": "100%",
                          "height": 380,
                          "tabs": [
                            {
                              "title": "Crypto",
                              "symbols": [
                                {
                                  "s": "BINANCE:BTCUSDT"
                                },
                                {
                                  "s": "BINANCE:ETHUSDT"
                                },
                                {
                                  "s": "CRYPTOCAP:USDT.D"
                                },
                                {
                                  "s": "BINANCE:BNBUSDT"
                                },
                                {
                                  "s": "CRYPTOCAP:USDC"
                                },
                                {
                                  "s": "BINANCE:XRPUSDT"
                                }
                              ],
                              "originalTitle": "Indices"
                            }
                          ]
                        }
                          </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
            </div>
        </div>  
        <div class="col-sm-6 col-lg-6">
            <div class="p-3 card shadow-none border ">
                <div class="row p-2">
                    <div class="col-12 p-0">
                        <div class="nk-block-head-content">
                            <h5 class="text-primary h5 mb-3">Market News</h5>
                        </div>
                    </div>
                    <div class="col-12 border rounded">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                          <div class="tradingview-widget-container__widget"></div>
                          <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
                          {
                          "feedMode": "market",
                          "market": "stock",
                          "colorTheme": "dark",
                          "isTransparent": true,
                          "displayMode": "regular",
                          "width": "100%",
                          "height": 380,
                          "locale": "en"
                        }
                          </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <!---->
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <h5 class="text-black">Refer Us & Earn</h5>
                    <p>Use the below link to invite your friends.</p>
                    <div class="mb-3 input-group">
                        <input type="text" class="form-control myInput readonly"
                            value="https://sterlinguniongroup.com/register?ref=<?php echo $user['email']; ?>" id="reflink" readonly style="border: 1px solid rgba(255,255,255,0.2);">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" onclick="myFunction()" type="button" style="padding:5px 12px; color: rgba(255,255,255,0.2);background: #2D2D2D;border: 1px solid rgba(255,255,255,0.2);">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

            </div>
   <?php include('footer.php'); ?>