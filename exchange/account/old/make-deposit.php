<?php 
include('header.php'); 

if(isset($_POST['deposit'])){
	$method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
}

if(isset($_POST['makedeposit'])){
  	$method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
    $plan = filter_var($_POST['plan'], FILTER_SANITIZE_STRING);
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

	header("location: " . htmlspecialchars($method) . ".php?plan=" . urlencode($plan) . "&amount=" . urlencode($amount));
    exit;
}

?>


            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Fund Your Account</h5>
            </div>
        </div>
    </div>
    <div>
    </div>	<div>
    </div>    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="" method="post" id="submitpaymentform">
                                <input type="hidden" name="csrfmiddlewaretoken" value="4yce0eEQAtnqbnBRUm5kikP5EYKOxZcgdzMBIMzQydgEfGqczOSp0iux6tw3UMph">
                                <div class="row">
                                  	<div class="mb-4 col-md-12">
                                        <h6 class="card-title ">Cryptocurrency</h6>
                                        <input class="form-control " placeholder="Enter method" value="<?php echo $method; ?>"
                                             type="text" name="method" value="" required readonly>
                                    </div>
                                    <div class="mb-4 col-md-12">
                                        <h6 class="card-title ">Enter Amount</h6>
                                        <input class="form-control " placeholder="Enter amount"
                                            min="50" type="number" name="amount" value="" required>
                                    </div>
                                 
                                    </div>
                                                        
                                        <div class="mt-3 mb-1 col-md-12">
                                            <input type="submit" name="makedeposit" class="px-5 btn btn-primary btn-lg w-100"
                                                value="Proceed to Payment">
                                        </div>
                                
                                                              
                            </form>
                        </div>
                        <div class="mt-4 col-md-4">
                            <!-- Seller -->
                            <div class="card shadow-none">
                                <div class="card-body">
                                    <div class="pb-4">
                                        <div class="">
                                            <!--regular account deposits-->
                                            <div class="rounded p-3 shadow option2 bg-light border border-primary" id="acnt">
                                                <small class="text-muted" style="font-size:0.7rem !important">TOTAL DEPOSIT</small>
                                                <h6 class="my-0">
                                                                                                                                                                        <h6 class="mb-1">
                                                    $<?php echo number_format($user['total_deposits'], 2, '.', ','); ?>
    														</h6>
                                                                                                                                                            </h6>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="actions d-flex justify-content-between">
                                        <a href="accounthistory.php" class="action-item">
                                            <span class="btn-inner--icon">View Deposit History</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
  document.getElementById("method").addEventListener("change", function () {
    // Hide all sub dropdowns
    document.querySelectorAll(".sub-method").forEach(el => el.style.display = "none");

    // Show the one that matches the selection
    const selected = this.value;
    const dropdown = document.getElementById(`${selected}-options`);
    if (dropdown) {
      dropdown.style.display = "block";
    }
  });
</script>

                </div>
                <?php include('footer.php'); ?>