<?php
include "includes/header.php";

$message = "";
if (isset($_POST['profit'])) {
    $amount = $_POST['amount'];
    $account = $_POST['account'];

    $fetchaccount = "SELECT * FROM users WHERE id = '$account'";
    $accquery = mysqli_query($conn, $fetchaccount);
    $getter = mysqli_fetch_assoc($accquery);
    $useremail = $getter['email'];
    $firstname = $getter['first_name'];
    $client_id = $getter['id'];
    $tranx_id = rand(000000, 999999);
    $coin = '$';
    $status = "completed";
    $newBal = $getter['total_balance'] + $amount;
    $newPro = $getter['total_bonus'] + $amount;
    $type = "bonus";
    $address = "";
    $prosql = "UPDATE clients set total_balance = '$newBal', total_bonus = '$newPro' WHERE id = '$account'";
    $proquery = mysqli_query($conn, $prosql);

    // $sqlpde = "INSERT INTO history (client_id, tranx_id, email, type, coin, address, amount, status) VALUES ( '$client_id', '$tranx_id', '$useremail', '$type', '$coin', '$address', '$amount', '$status')";
    // $stmtde = mysqli_query($conn, $sqlpde);

    $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Bonus of ' . $amount . ' added to ' . $useremail . ' successfully</div>
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
                        <h3 class="box-title">Add Bonus To a User</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <?php echo $message; ?>
                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputltc">Amount</label>
                                <input type="text" name="amount" class="form-control" id="exampleInputltc"
                                    placeholder="Enter amount">
                            </div>
                            <div class="form-group">
                                <label style="padding-right: 5px;" for="exampleInputltc">Select an
                                    account</label>
                                <select class="form-control" name="account">
                                    <option>
                                        -- select --</option>
                                    <?php
while ($fetchuser = mysqli_fetch_assoc($query)) {
    ?>
                                    <option value="<?php echo $fetchuser['id']; ?>"><?php echo $fetchuser['email']; ?>
                                    </option>
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
include "includes/footer.php";

?>