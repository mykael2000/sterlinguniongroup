<?php
include "includes/header.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$userid = $_GET['id'];
$sqleu = "SELECT * FROM users WHERE id='$userid'";
$queryeu = mysqli_query($conn, $sqleu);
$usereu = mysqli_fetch_assoc($queryeu);
$message = "";
if (isset($_POST['submit'])) {
    $total_balance = $_POST['total_balance'];
    $btc_balance = $_POST['btc_balance'];
  	$eth_balance = $_POST['eth_balance'];
   	$usdt_balance = $_POST['usdt_balance'];
  	$sol_balance = $_POST['sol_balance'];
  	$gen_balance = $_POST['gen_balance'];
    $withdrawal = $_POST['total_withdrawals'];
    $today_pnl = $_POST['today_pnl'];
    $today_pnl_percentage = $_POST['today_pnl_percentage'];
  	$total_deposits = $_POST['total_deposits'];
  	$active_deposits = $_POST['active_deposits'];
  	$total_earnings = $_POST['total_earnings'];
  	$total_referrals = $_POST['total_referrals'];
  	$pending_withdrawals = $_POST['pending_withdrawals'];
    $sqlup = "UPDATE users set total_balance='$total_balance', btc_balance='$btc_balance', eth_balance='$eth_balance', usdt_balance='$usdt_balance', sol_balance='$sol_balance', gen_balance='$gen_balance', total_withdrawals='$withdrawal', today_pnl = '$today_pnl',
    today_pnl_percentage = '$today_pnl_percentage', total_deposits = '$total_deposits', active_deposits = '$active_deposits', total_earnings = '$total_earnings', total_referrals = '$total_referrals', pending_withdrawals = '$pending_withdrawals' WHERE id='$userid'";
    $queryup = mysqli_query($conn, $sqlup);
    header("location: edit.php?id=$userid&message=success");
}
if (@$_GET['message'] == "success") {
    $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Details Updated Successfully</div>
        </div>';
}

?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sterling Union GroupUsers List

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Home</a></li>
            <li class="#">users</li>
            <li class="active">edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit User</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <?php echo $message; ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    value="<?php echo $usereu['email']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Total Balance</label>
                                <input type="text" name="total_balance" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['total_balance']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">BTC Balance</label>
                                <input type="text" name="btc_balance" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['btc_balance']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">ETH Balance</label>
                                <input type="text" name="eth_balance" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['eth_balance']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">USDT Balance</label>
                                <input type="text" name="usdt_balance" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['usdt_balance']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">SOL Balance</label>
                                <input type="text" name="sol_balance" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['sol_balance']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">GEN Balance</label>
                                <input type="text" name="gen_balance" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['gen_balance']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Todays PNL</label>
                                <input type="number" step="any" name="today_pnl" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['today_pnl']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Todays PNL Percentage</label>
                                <input type="number" step="any" name="today_pnl_percentage" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter percentage" value="<?php echo $usereu['today_pnl_percentage']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">Total Deposits</label>
                                <input type="text" name="total_deposits" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['total_deposits']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">Active Deposits</label>
                                <input type="text" name="active_deposits" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['active_deposits']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">Total Earnings</label>
                                <input type="text" name="total_earnings" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['total_earnings']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">Total Referrals</label>
                                <input type="text" name="total_referrals" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter number" value="<?php echo $usereu['total_referrals']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">Pending Withdrawals</label>
                                <input type="text" name="pending_withdrawals" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['pending_withdrawals']; ?>">
                            </div>
                            
                          
                          
                            <div class="form-group">
                                <label for="exampleInputbtc">Total Withdrawals</label>
                                <input type="text" name="total_withdrawals" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['total_withdrawals']; ?>">
                            </div>
                           
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div><!-- /.box -->



            </div>
            <!--/.col (left) -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include "includes/footer.php";

?>