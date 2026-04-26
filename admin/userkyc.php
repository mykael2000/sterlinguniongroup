<?php
include "includes/header.php";

$sqldepo = "SELECT * FROM kyc_submissions";
$querydepo = mysqli_query($conn, $sqldepo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submission_id = (int)($_POST['submission_id'] ?? 0);
    $user_id = (int)($_POST['user_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($submission_id > 0 && $user_id > 0 && in_array($action, ['approve', 'reject'])) {

        // Map 'approve' to status 'approved' etc.
        $status = $action === 'approve' ? 'verified' : 'rejected';

        // Begin transaction for atomic update
        $conn->begin_transaction();

        try {
            // Update the kyc_submissions table status
            $stmt1 = $conn->prepare("UPDATE kyc_submissions SET status = ? WHERE id = ?");
            $stmt1->bind_param("si", $status, $submission_id);
            $stmt1->execute();
            $stmt1->close();

            if ($action === 'approve') {
                // Also update users table kyc_status to 'approved'
                $stmt2 = $conn->prepare("UPDATE users SET kyc_status = 'verified' WHERE id = ?");
                $stmt2->bind_param("i", $user_id);
                $stmt2->execute();
                $stmt2->close();
            } elseif ($action === 'reject') {
                // Optionally update users kyc_status to 'rejected' or keep unchanged
                $stmt3 = $conn->prepare("UPDATE users SET kyc_status = 'rejected' WHERE id = ?");
                $stmt3->bind_param("i", $user_id);
                $stmt3->execute();
                $stmt3->close();
            }

            $conn->commit();
            $_SESSION['message'] = 'KYC ' . ucfirst($status) . ' successfully.';
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['message'] = 'Error updating KYC status: ' . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = 'Invalid request.';
    }
}
?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sterling Union GroupKYC List

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Home</a></li>
            <li class="active">kyc</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">KYC</h3>
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


                                <th>Email</th>

                                
                                <th>Identity Document Type</th>
                              <th>Document Number</th>
                                <th> Document Front</th>
                               <th> Document Back</th>
                               <th> Status</th>

                            </tr>
                            <?php while ($depo = mysqli_fetch_assoc($querydepo)) {?>
                            <tr>
                                <td><?php echo $depo['email']; ?></td>

                                
                                <td><?php echo $depo['document_type']; ?></td>
                              <td><?php echo $depo['document_number']; ?></td>
                                <td><a href="../exchange/account/<?php echo $depo['front_image_path']; ?>" target="__blank"
                                        class="btn btn-block btn-success btn-xs">Download</a></td>
                               
                                <td><a href="../exchange/account/<?php echo $depo['back_image_path']; ?>" target="__blank"
                                        class="btn btn-block btn-success btn-xs">Download</a></td>
								 <td><?= htmlspecialchars($depo['status']) ?></td>
                            <td>
                                <?php if (strtolower($depo['status']) === 'pending'): ?>
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="submission_id" value="<?= (int)$depo['id'] ?>">
                                    <input type="hidden" name="user_id" value="<?= (int)$depo['user_id'] ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-xs">Approve</button>
                                </form>
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="submission_id" value="<?= (int)$depo['id'] ?>">
                                    <input type="hidden" name="user_id" value="<?= (int)$depo['user_id'] ?>">
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-xs">Reject</button>
                                </form>
                                <?php else: ?>
                                    <span class="text-gray-500"><?= ucfirst(htmlspecialchars($depo['status'])) ?></span>
                                <?php endif; ?>
                            </td>


                            </tr>
                            <?php }?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include "includes/footer.php";

?>