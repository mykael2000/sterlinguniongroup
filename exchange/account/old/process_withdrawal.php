<?php 
include('header.php'); 

if(isset($_POST['withdraw'])){
	$withdrawal_method = $_POST['method'];
}

if(isset($_POST['place_withdrawal'])){
	$withdrawal_method = $_POST['withdrawal_method'];
  	$amount = $_POST['amount'];
  	$client_id = $user['id'];
    $tranx_id = rand(10000,99999);
    $email = $user['email'];
    $status = 'Pending';

  	if(empty($_POST['account_number'])){
    	$details = $_POST['details'];
    }else{
  		$details = $_POST['details'].'/'.$_POST['account_number'].'/'.$_POST['bank_name'].'/'.$_POST['swift_code'];
    }
  if($user['withdrawal_pin'] !== $_POST['pin']){
    	echo "<script>alert('Your pin is incorrect, Try again!!')</script>";
    }else{
  	if($user['account_status'] !== 'verified'){
    	echo "<script>alert('Your account is currently unverified, kindly contact support!!')</script>";
    }elseif($user['upgrade_status'] !== 'deactive'){
    	echo "<script>alert('Your account needs to be upgraded, kindly contact support!!')</script>";
    }elseif($user['trade_session'] == 'started'){
    	echo "<script>alert('Your trade session is currently on needs to be ended first, kindly contact support!!')</script>";
    }elseif($user['comm_fee'] !== 'paid'){
    	echo "<script>alert('You are required to pay your commission fee , kindly contact support!!')</script>";
    }elseif($user['broker_fee'] !== 'paid'){
    	echo "<script>alert('You are required to pay your trading and brokerage fees, kindly contact support!!')</script>";
    }elseif(empty($user['withdrawal_pin'])){
    	echo "<script>alert('kindly contact support to generate a withdrawal pin for your transaction!!')</script>";
    }else{
    	$with_sql = "INSERT into withdrawals (client_id, tranx_id, email, amount, withdrawal_method, details, status) VALUES ('$client_id','$tranx_id','$email','$amount','$withdrawal_method','$details','$status')";
      mysqli_query($conn, $with_sql);
    	echo "<script>alert('Withdrawal successfully placed!!')</script>";
      header('refresh: 1; url=index.php');
    }
  }
}


?>


            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Place a Withdrawal</h5>
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
                                        <h6 class="card-title ">Withdrawal Method</h6>
                                        <input class="form-control " placeholder="Enter Method"
                                         type="text" name="withdrawal_method" value="<?php echo $withdrawal_method; ?>" readonly>
                                    </div>
                                    <div class="mb-4 col-md-12">
                                        <h6 class="card-title ">Enter Amount</h6>
                                        <input class="form-control" placeholder="Enter Amount"
                                            min="50" type="number" name="amount" value="" required>
                                    </div>
           							<div class="mb-4 col-md-12">
                                        <h6 class="card-title ">Account Details (Email/Username/Address)</h6>
                                        <input class="form-control " placeholder="Enter Details"
                                         type="text" name="details" required>
                                    </div>
                                  	<?php if($withdrawal_method == "Bank Transfer"){ ?>
                                  	<div class="mb-4 col-md-12">
                                          <h6 class="card-title ">Account Number </h6>
                                        <input class="form-control " placeholder="Enter Account Number"
                                         type="text" name="account_number" required>
                                    </div>
                                  	<div class="mb-4 col-md-12">
                                          <h6 class="card-title ">Bank Name </h6>
                                        <input class="form-control " placeholder="Enter Bank Name"
                                         type="text" name="bank_name" required>
                                    </div>
                                  	<div class="mb-4 col-md-12">
                                          <h6 class="card-title ">Swift Code </h6>
                                        <input class="form-control " placeholder="Enter Swift Code"
                                         type="text" name="swift_code" required>
                                    </div>
                                  	<?php } ?>
                                    <div class="mb-4 col-md-12">
                                        <h6 class="card-title ">Withdrawal Pin</h6>
                                      <span style="font-size: 8px; color: red;">Kindly generate one with our support team if you do not have any</span>
                                        <input class="form-control " placeholder="Enter pin"
                                         type="text" name="pin" required>
                                    </div>
                               
                                        <div class="mt-3 mb-1 col-md-12">
                                            <input type="submit" name="place_withdrawal" class="px-5 btn btn-primary btn-lg w-100"
                                                value="Proceed to Withdrawal">
                                        </div>
                                        
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
                                                <small class="text-muted" style="font-size:0.7rem !important">TOTAL Balance</small>
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