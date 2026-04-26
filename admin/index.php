<?php
include "includes/header.php";

$BTC = 1;
$sqlBTC = "SELECT * FROM wallet WHERE id = '$BTC'";
$queryBTC = mysqli_query($conn, $sqlBTC);
$getdetailsBTC = mysqli_fetch_assoc($queryBTC);

$ETH = 2;
$sqlETH = "SELECT * FROM wallet WHERE id = '$ETH'";
$queryETH = mysqli_query($conn, $sqlETH);
$getdetailsETH = mysqli_fetch_assoc($queryETH);

$USDT = 3;
$sqlUSDT = "SELECT * FROM wallet WHERE id = '$USDT'";
$queryUSDT = mysqli_query($conn, $sqlUSDT);
$getdetailsUSDT = mysqli_fetch_assoc($queryUSDT);

$BNB = 4;
$sqlBNB = "SELECT * FROM wallet WHERE id = '$BNB'";
$queryBNB = mysqli_query($conn, $sqlBNB);
$getdetailsBNB = mysqli_fetch_assoc($queryBNB);

use PHPMailer\PHPMailer\PHPMailer;

//Load Composer's autoloader

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// SQL query to get the total number of users
$sqlt = "SELECT COUNT(*) as total_users FROM users";

// Execute the query
$result = mysqli_query($conn, $sqlt);

if ($result) {
    // Fetch the result as an associative array
    $row = mysqli_fetch_assoc($result);

    // Get the total number of users
    $totalUsers = $row['total_users'];

    // Output the total number of users

} else {
    // Handle the query error
    echo "Error: " . mysqli_error($conn);
}

// SQL query to get the total amount where status is "completed"
$sqltaL = "SELECT SUM(active_deposits) AS total_amountL FROM users";

// Execute the query
$resultL = mysqli_query($conn, $sqltaL);

if ($resultL) {
    // Fetch the result as an associative array
    $rowL = mysqli_fetch_assoc($resultL);

    // Get the total amount
    $totalLTCAmount = $rowL['total_amountL'];

    // Output the total amount

} else {
    // Handle the query error
    echo "Error: " . mysqli_error($conn);
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $totalUsers; ?></h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>$<?php if (empty($totalLTCAmount)) {echo 0;} else {echo $totalLTCAmount;}?></h3>
                        <p>Total Active Deposits</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="box-body">
                <h5>BTC Address</h5>
                <div class="form-group">
                    <input class="form-control" type="text" value="<?php echo $getdetailsBTC['address']; ?>" readonly>
                    <img height="100px" width="100px"
                        src="../address/<?php echo $getdetailsBTC['qrcode']; ?>">
                </div>

            </div>
            <div class="box-body">
                <h5>ETH Address</h5>
                <div class="form-group">
                    <input class="form-control" type="text" value="<?php echo $getdetailsETH['address']; ?>" readonly>
                    <img height="100px" width="100px"
                        src="../address/<?php echo $getdetailsETH['qrcode']; ?>">
                </div>

            </div>
            <div class="box-body">
                <h5>USDT Address</h5>
                <div class="form-group">
                    <input class="form-control" type="text" value="<?php echo $getdetailsUSDT['address']; ?>" readonly>
                    <img height="100px" width="100px"
                        src="../address/<?php echo $getdetailsUSDT['qrcode']; ?>">
                </div>

            </div>
            <div class="box-body">
                <h5>BNB Address</h5>
                <div class="form-group">
                    <input class="form-control" type="text" value="<?php echo $getdetailsBNB['address']; ?>" readonly>
                    <img height="100px" width="100px"
                        src="../address/<?php echo $getdetailsBNB['qrcode']; ?>">
                </div>

            </div>
        </div>
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->

                <!-- quick email widget -->
                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-envelope"></i>
                        <h3 class="box-title">Quick Email</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                                title="Remove"><i class="fa fa-times"></i></button>
                        </div><!-- /. tools -->
                    </div>
                    <div class="box-body">
                        <form action="#" method="post">
                            <div class="form-group">
                                <input type="email" class="form-control" name="emailto" placeholder="Email to:" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" />
                            </div>
                            <div>
                                <textarea class="textarea" placeholder="Message"
                                    style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer clearfix">
                        <button class="pull-right btn btn-default" id="sendEmail">Send <i
                                class="fa fa-arrow-circle-right"></i></button>
                    </div>
                </div>

            </section><!-- /.Left col -->

        </div><!-- /.row (main row) -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include "includes/footer.php";

?>