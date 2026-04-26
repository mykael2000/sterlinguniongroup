<?php
include "includes/header.php";

$message = "";

// Handle form submission to update the database
if (isset($_POST['update_address'])) {
    $coin_id = $_POST['coin_id'];
    $new_address = mysqli_real_escape_string($conn, $_POST['new_address']);

    // Validate coin_id is one of the allowed IDs
    if (!in_array($coin_id, ['1', '2', '3'])) {
        $message = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>Invalid wallet ID. Only BTC, ETH, and USDT can be updated.</div>
                </div>';
    } else {
        // Generate QR code URL
        $new_qrcode_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($new_address);

        $update_sql = "UPDATE coin_wallet SET address = ?, qrcode = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "ssi", $new_address, $new_qrcode_url, $coin_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
                        <div>Wallet address updated successfully!</div>
                    </div>';
        } else {
            $message = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div>Error updating wallet address: ' . mysqli_error($conn) . '</div>
                    </div>';
        }
        mysqli_stmt_close($stmt);
    }
}

// Fetch only the wallets with IDs 1, 2, and 3
$wallets_sql = "SELECT id, coin, network, address, qrcode FROM coin_wallet WHERE id IN (1, 2, 3) ORDER BY id ASC";
$wallets_query = mysqli_query($conn, $wallets_sql);
$wallets = mysqli_fetch_all($wallets_query, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard <small>Control panel</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Wallets</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo $message; ?>
            </div>
            <?php foreach ($wallets as $wallet): ?>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit <?php echo htmlspecialchars($wallet['coin']); ?> Wallet</h3>
                    </div>
                    <form action="" method="post" role="form">
                        <input type="hidden" name="coin_id" value="<?php echo htmlspecialchars($wallet['id']); ?>">
                        <div class="box-body">
                            <div class="form-group text-center">
                                <label>Current QR Code (<?php echo htmlspecialchars($wallet['coin']); ?>)</label>
                                <br>
                                <img src="<?php echo htmlspecialchars($wallet['qrcode']); ?>" alt="QR Code" style="width:150px;height:150px;border:1px solid #ccc;">
                            </div>
                            
                            <div class="form-group">
                                <label>Current Address</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($wallet['address']); ?>" readonly>
                            </div>
                            
                            <hr>
                            <h4 class="text-center">Update Address</h4>
                            <div class="form-group">
                                <label for="new_address_<?php echo htmlspecialchars($wallet['id']); ?>">New Wallet Address</label>
                                <input type="text" name="new_address" id="new_address_<?php echo htmlspecialchars($wallet['id']); ?>" class="form-control" placeholder="Enter new wallet address" required>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button name="update_address" type="submit" class="btn btn-primary">Update Address</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php include "includes/footer.php"; ?>