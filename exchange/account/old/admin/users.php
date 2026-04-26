<?php 
include("includes/header.php");

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
            <li class="active">users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Total Users</h3>
                        <div class="box-tools">
                            <div class="input-group">
                                <input type="text" name="table_search" class="form-control input-sm pull-right"
                                    style="width: 150px;" placeholder="Search" />
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>

                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Country</th>

                                <th>Zip</th>
                                <th>City</th>
                                <th>Currency</th>
                                <th>Total Balance</th>
                                <th>BTC Balance</th>
                                <th>ETH Balance</th>
                                <th>USDT Balance</th>
                                <th>LTC Balance</th>
                                <th>Created at</th>
                            </tr>
                            <?php while($user = mysqli_fetch_assoc($query)){  ?>
                            <tr>

                                <td><?php echo $user['firstname']; ?></td>
                                <td><?php echo $user['lastname']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['phone']; ?></td>
                                <td><?php echo $user['address']; ?></td>
                                <td><?php echo $user['country']; ?></td>

                                <td><?php echo $user['zip']; ?></td>
                                <td><?php echo $user['city']; ?></td>
                                <td><?php echo $user['currency']; ?></td>
                                <td><?php echo $user['total_balance']; ?></td>
                                <td><?php echo $user['btc_balance']; ?></td>
                                <td><?php echo $user['eth_balance']; ?></td>
                                <td><?php echo $user['usdt_balance']; ?></td>
                                <td><?php echo $user['ltc_balance']; ?></td>
                                <td><?php echo $user['created_at']; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include("includes/footer.php");

?>