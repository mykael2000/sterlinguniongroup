<?php 
include('header.php'); 
$id = $user['id'];
if(isset($_POST['swap'])){
  	
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	if($amount > $user['total_balance']){
    	echo "<script>alert('Account balance is too low to swap, kindly make a deposit first')</script>";
    }else{
      $newtotal = $user['total_balance'] - $amount;
      $newtoken = $user['token_balance'] + $amount;
    	$sql_upp = "UPDATE users set total_balance = '$newtotal', token_balance = '$newtoken' WHERE id = '$id'";
      	mysqli_query($conn,$sql_upp);
      echo "<script>alert('USD Swapped successfully!!')</script>";
      header('refresh:1;url=swap.php');
    }
}

?>


            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Swap USD for Tesla Token</h5>
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
                                        <h6 class="card-title ">Enter Token Amount</h6>
                                        <input class="form-control " placeholder="Enter Amount"
                                            min="1" type="number" name="amount" value="" required>
                                    </div>
                                  

                                        <div class="mt-3 mb-1 col-md-12">
                                            <input type="submit" name="swap" class="px-5 btn btn-primary btn-lg w-100"
                                                value="Proceed to Swap">
                                        </div>
                                        <input type="hidden" id="lastchosen" value="0">
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
                                                <small class="text-muted" style="font-size:0.7rem !important">Total Balance</small>
                                                <h6 class="my-0">
                                                                                                                                                                        <h6 class="mb-1">
                                                    $<?php echo number_format($user['total_balance'], 2, '.', ','); ?>
    														</h6>
                                                                                                                                                            </h6>
                                            </div>
                                            <!---->
                                        </div>
                                    </div>
                                    
                                </div>
                              <div class="card-body">
                                    <div class="pb-4">
                                        <div class="">
                                            <!--regular account deposits-->
                                            <div class="rounded p-3 shadow option2 bg-light border border-primary" id="acnt">
                                                <small class="text-muted" style="font-size:0.7rem !important">Token Balance</small>
                                                <h6 class="my-0">
                                                                                                                                                                        <h6 class="mb-1">
                                                    $<?php echo number_format($user['token_balance'], 2, '.', ','); ?>
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
                                            <span class="btn-inner--icon">View Deposit History<i class="far fa-arrow-right ml-2"></i></span>
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
                </div>
                <?php include('footer.php'); ?>