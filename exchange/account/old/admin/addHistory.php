<?php 
include("includes/header.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load PHPMailer classes
require '../account/PHPMailer-master/src/PHPMailer.php';
require '../account/PHPMailer-master/src/Exception.php';
require '../account/PHPMailer-master/src/SMTP.php';

$message = "";

if(isset($_POST['profit'])){
  // Generate 10 random bytes (1 byte = 2 hex characters)
$random_bytes = random_bytes(10); 

// Convert the random bytes to a 20-character hexadecimal hash
$hash = bin2hex($random_bytes); 

    $amount = $_POST['amount'];
  	$fees = $_POST['fees'];
    $account = $_POST['account'];
    
    $fetchaccount = "SELECT * FROM users WHERE id = '$account'";
    $accquery = mysqli_query($conn, $fetchaccount);
    $getter = mysqli_fetch_assoc($accquery);
    $useremail = $getter['email'];
    $firstname = $getter['firstname'];
    $client_id = $getter['id'];
    $tranx_id = rand(000000,999999);
    $coin = $_POST['coin'];
  	$exchange_rate = $_POST['exchange_rate'];
  	$sender_address = $_POST['sender_address'];
  	$receiver_address = $_POST['receiver_address'];
    $status = "completed";
    $type = $_POST['type'];
  	$details = $_POST['details'];
  	$description = $_POST['description'];
  	$date = $_POST['date_of_hist'];
  
    $sqlpde = "INSERT INTO history (client_id, tranx_id, tranx_hash, email, type, coin, amount, fees, details, description, exchange_rate, sender_address, receiver_address, status, date_of_hist) 
    		VALUES ( '$client_id', '$tranx_id', '$hash', '$useremail', '$type', '$coin', '$amount', '$fees', '$details', '$description', '$exchange_rate', '$sender_address','$receiver_address', '$status', '$date')";
    $stmtde = mysqli_query($conn, $sqlpde);
      $mail = new PHPMailer(true);
	try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.zoho.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'support@sterlinguniongroup.com'; // Your SMTP username
                    $mail->Password   = 'ZEtr232@ULt';           // Your SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL implicit TLS
                    $mail->Port       = 465;

                    // Recipients
                    $mail->setFrom('support@sterlinguniongroup.com', 'Support');
                    $mail->addAddress($useremail); // Add a recipient
               

                    // Content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = $type.' Alert - Prime Jarvis';
                    $mail->Body    = "
                    <html>
                    <head></head>
                    <body style='background-color: #1e2024; padding: 45px;'>
                        <div>
                            <img style='position:relative; left:35%; border-radius: 50%; height: 100px; width: 100px;' src='https://sterlinguniongroup.com/logo.jpg'>
                            <h3 style='color: black;'>Mail From support@sterlinguniongroup.com - ".$type." Alert</h3>
                        </div>
                        <div style='color: #fff;'>
                            
                            <p>Your Account has been ".$type."d with the amount of ".$amount.". Kindly log in to view available balance</p>
                           
                            <h5>Note: Do not disclose the details in this email to anyone.</h5>
                        </div>
                        <div style='background-color: white; color: black;'>
                            <h3 style='color: black;'>Support@sterlinguniongroup.com</h3>
                        </div>
                    </body>
                    </html>";
                    // $mail->AltBody = 'This is the plain text version for non-HTML mail clients'; // Optional plain text body

                    $mail->send();
                   
                } catch (Exception $e) {
                    $message = "<div class='alert alert-warning'>Account created, but email could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
                    // Log the error for debugging, but don't prevent user from seeing success
                    error_log("PHPMailer Error for email {$email}: {$mail->ErrorInfo}");
                     
                }
    
    
    $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>History added to '.$useremail.' successfully</div>
        </div>';
       
}





// Close the database connection
mysqli_close($conn);
?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <!-- Main row -->
        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add History To a User</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <?php echo $message;  ?>
                        <div class="box-body">
                            
                            <div class="form-group">
                                <label for="exampleInputltc">Amount($)</label>
                                <input type="number" step="any" name="amount" class="form-control" id="exampleInputltc"
                                    placeholder="Enter amount">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputltc">Transaction Fees($)</label>
                                <input type="number" step="any" name="fees" class="form-control" id="exampleInputltc"
                                    placeholder="Enter fees">
                            </div>
                          	<div class="form-group">
                                <label for="exampleInputltc">Details</label>
                                <input type="text" name="details" class="form-control" id="exampleInputltc"
                                    placeholder="Enter details">
                            </div>
                          	<div class="form-group">
                                <label for="exampleInputltc">Description</label>
                                <input type="text" name="description" class="form-control" id="exampleInputltc"
                                    placeholder="Enter description">
                            </div>
                          	<div class="form-group">
                                <label for="exampleInputltc">Coin</label>
                                <select class="form-control" name="coin">
                                    <option>--select--</option>
                                  <option value="BTC">BTC</option>
                                  <option value="ETH">ETH</option>
                                  <option value="LTC">LTC</option>
                                  <option value="USDT">USDT</option>
                            	</select>
                            </div>
                          <div class="form-group">
                                <label for="exampleInputltc">Exchange Rate</label>
                                <input type="text" name="exchange_rate" class="form-control" id="exampleInputltc"
                                    placeholder="Enter Exchange Rate">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputltc">Sender Address</label>
                                <input type="text" name="sender_address" class="form-control" id="exampleInputltc"
                                    placeholder="Enter Address">
                            </div>
                           <div class="form-group">
                                <label for="exampleInputltc">Receiver Address</label>
                                <input type="text" name="receiver_address" class="form-control" id="exampleInputltc"
                                    placeholder="Enter Address">
                            </div>
                      
                          	<div class="form-group">
                                <label for="exampleInputltc">TYPE</label>
                                <select class="form-control" name="type">
                                    <option>--select--</option>
                                  <option value="credit">CREDIT</option>
                                  <option value="debit">DEBIT</option>
                            	</select>
                            </div>
                          <div class="form-group">
                                <label for="exampleInputltc">Date of Transaction</label>
                                <input type="datetime-local" name="date_of_hist" class="form-control" id="exampleInputltc"
                                    placeholder="Enter date_of_hist">
                            </div>
                            <div class="form-group">
                                <label style="padding-right: 5px;" for="exampleInputltc">Select an account</label>
                                <select class="form-control" name="account">
                                    <option>
                                        -- select --</option>
                                        <?php 
                                            while($fetchuser = mysqli_fetch_assoc($query)){
                                        ?>
                                    <option value="<?php echo $fetchuser['id']; ?>"><?php echo $fetchuser['email']; ?></option>
                                   <?php 
                                            }
                                   ?>

                                </select>
                            </div>
                           

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button name="profit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div><!-- /.box -->



            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include("includes/footer.php");

?>