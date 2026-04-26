<?php include('header.php'); 
$userid = $user['id'];
$sqldep = "SELECT * FROM history WHERE client_id = '$userid'";
    $querydep = mysqli_query($conn, $sqldep);
?>

            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Transaction Records</h5>
            </div>
        </div>
    </div>
    <div>
    </div>    <div>
    </div>    
              <div class="row">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <ul class="mb-5 nav nav-pills nav-pills-icon nav-justified" id="pills-tab" role="tablist">
                        <li class="pr-2 " role="presentation">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                                aria-controls="pills-home" aria-selected="true">
                                <span class="text-sm d-block">History</span>
                            </a>
                        </li>
                    </ul>
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
                                  while ($trans = mysqli_fetch_assoc($query_fetch)) {
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
                                                  <?php echo $sign . ' ' . number_format($trans['amount'], 8, '.', ',') . ' ' . htmlspecialchars($trans['coin']); ?>
                                              </div>
                                              <div class="transaction-amount-dollar">
                                                  <?php echo $sign . ' $' . number_format($trans['amount'], 2, '.', ','); ?>
                                              </div>
                                              
                                          </div>
                                      </div>
                                </a>
                                  <?php
                                  }
                                  ?>
                              </div>
                          </div>
                      </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!--end of recent transactions-->

                </div>
            </div>
        </div>
    </div>
            </div>
            <?php include('footer.php'); ?>