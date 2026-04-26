<?php 
include("includes/header.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader

require '../account/PHPMailer-master/src/PHPMailer.php';
require '../account/PHPMailer-master/src/Exception.php';
require '../account/PHPMailer-master/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
 


if(isset($_POST['profit'])){
    $amount = $_POST['amount'];
    $account = $_POST['account'];
    
    $fetchaccount = "SELECT * FROM users WHERE id = '$account'";
    $accquery = mysqli_query($conn, $fetchaccount);
    $getter = mysqli_fetch_assoc($accquery);
    $useremail = $getter['email'];
    $firstname = $getter['firstname'];
    $client_id = $getter['id'];
    $tranx_id = rand(000000,999999);
    $coin = $getter['currency'];
    $status = "completed";
    $newBal = $getter['total_balance'] + $amount;
    $newPro = $getter['total_bonus'] + $amount;
    $type = "bonus";
    $address = "";
    $prosql = "UPDATE users set total_balance = '$newBal', total_bonus = '$newPro' WHERE id = '$account'";
    $proquery = mysqli_query($conn, $prosql);
    
    $sqlpde = "INSERT INTO history (client_id, tranx_id, email, type, coin, address, amount, status) VALUES ( '$client_id', '$tranx_id', '$useremail', '$type', '$coin', '$address', '$amount', '$status')";
    $stmtde = mysqli_query($conn, $sqlpde);
      

    
    
    $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Bonus of '.$amount.' added to '.$useremail.' successfully</div>
        </div>';
        try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.zoho.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'support@sterlinguniongroup.com';                     //SMTP username
    $mail->Password   = 'ZEcvut342@d';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('support@sterlinguniongroup.com', 'Support');
    $mail->addAddress($useremail);     //Add a recipient               //Name is optional
    
    $mail->addCC('support@sterlinguniongroup.com');
   
   

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Bonus added';
    $mail->Body    = '<html><head></head></head>
<body style="background-color: #1e2024; padding: 45px;">
    <div>
        <img style="position:relative; left:35%;" src="https://sterlinguniongroup.com/dash/dashboard/logo.png">
        <h3 style="color: black;">Mail From sterlinguniongroup.com - Bonus Added</h3>
    </div>
    <div style="color: #ffff;"><hr/>
        <h3>Dear '.$firstname.'</h3>
        <p>Bonus of '.$amount.' has successfully been credited to your account, kindly sign in to view your balance</p>
       
        <a style="background-color:#060c39;color:#ffff; padding:15px; text-decoration:none;border-radius: 10px;font-size: 20px;" href="https://sterlinguniongroup.com/dash/dashboard/auth/signin.php" class="btn btn primary">Sign in</a>
       
        <h5>Note : the details in this email should not be disclosed to anyone</h5>
            
    </div><hr/>
        <div style="background-color: white; color: black;">
            <h3 style="color: black;">support@Prime Jarvis<sup>TM</sup> </h3>
        </div>
        
</body></html>

';
   
    $mail->send();
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
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
                        <h3 class="box-title">Add Bonus To a User</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <?php echo $message;  ?>
                        <div class="box-body">
                            
                            <div class="form-group">
                                <label for="exampleInputltc">Amount</label>
                                <input type="text" name="amount" class="form-control" id="exampleInputltc"
                                    placeholder="Enter amount">
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