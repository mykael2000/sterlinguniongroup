<?php 
include("includes/header.php");


$sqlbtc = "SELECT * FROM settings WHERE id = '1'";
$querybtc = mysqli_query($conn, $sqlbtc);
$btc = mysqli_fetch_assoc($querybtc);

$sqleth = "SELECT * FROM settings WHERE id = '2'";
$queryeth = mysqli_query($conn, $sqleth);
$eth = mysqli_fetch_assoc($queryeth);

$sqlusdt = "SELECT * FROM settings WHERE id = '3'";
$queryusdt = mysqli_query($conn, $sqlusdt);
$usdt = mysqli_fetch_assoc($queryusdt);

$message = "";
$messagewith = "";


if(isset($_POST['submit'])){
   
    $btc_address = $_POST['btc_address'];
  	$eth_address = $_POST['eth_address'];
    $usdt_address = $_POST['usdt_address'];
   
  	$sqlbtc_up = "UPDATE settings set address = '$btc_address' WHERE id = '1'";
    $querybtc_up = mysqli_query($conn, $sqlbtc_up);
    
    $sqleth_up = "UPDATE settings set address = '$eth_address' WHERE id = '2'";
    $queryeth_up = mysqli_query($conn, $sqleth_up);

    $sqlusdt_up = "UPDATE settings set address = '$usdt_address' WHERE id = '3'";
    $queryusdt_up = mysqli_query($conn, $sqlusdt_up);
    

  

  	
    header("refresh: 1; url=editwallets.php");
}


?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CPT Users List

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
                        <h3 class="box-title">Edit Wallets</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <?php echo $message;  ?>
                        <div class="box-body">
                          <div class="form-group">
                                <label for="exampleInputbtc">BTC Address</label>
                                <input type="text" name="btc_address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter address" value="<?php echo $btc['address']; ?>">
                            </div>
                          <div class="form-group">
                                <label for="exampleInputbtc">ETH Address</label>
                                <input type="text" name="eth_address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter address" value="<?php echo $eth['address']; ?>">
                            </div>
                            
                          <div class="form-group">
                                <label for="exampleInputbtc">USDT Address</label>
                                <input type="text" name="usdt_address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter address" value="<?php echo $usdt['address']; ?>">
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
include("includes/footer.php");

?>