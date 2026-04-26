<?php include('header.php'); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['update'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone_number'];
    $country = $_POST['country'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    // Initialize variables for profile picture update
    $profile_update_needed = false;
    $new_profile_pic_name = ''; // This will store the new file name if uploaded

    // Check if a new profile picture was uploaded
    // Use $_FILES['profile']['error'] to check for actual upload success/failure
    // UPLOAD_ERR_NO_FILE indicates no file was selected/uploaded
    if (isset($_FILES["profile"]) && $_FILES["profile"]["error"] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        $fileName = basename($_FILES["profile"]["name"]);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Generate a unique filename to prevent overwrites
        $new_profile_pic_name = uniqid("img_", true) . "." . $fileExt;
        $targetFile = $uploadDir . $new_profile_pic_name;

        // Attempt to move the uploaded file
        if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {
            $profile_update_needed = true;
            // Optionally, delete the old profile picture to save space
            // You would need to fetch the old profilePic name from $user['profilePic'] here
            // if ($user['profilePic'] && file_exists($uploadDir . $user['profilePic'])) {
            //     unlink($uploadDir . $user['profilePic']);
            // }
        } else {
            // Error uploading file, alert the user and stop processing
            echo "<script>alert('Error uploading profile picture. Please try again.');</script>";
            // Consider redirecting or stopping here if profile pic is critical
            exit(); // Stop execution if upload failed
        }
    }

    // Prepare the SQL query based on whether a profile picture was updated
    if ($profile_update_needed) {
        $update_sql = "UPDATE users SET profilePic = ?, firstname = ?, lastname = ?, country = ?, phone = ?, DOB = ?, address = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        if ($update_stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $update_stmt->bind_param("sssssssi", $new_profile_pic_name, $firstname, $lastname, $country, $phone, $dob, $address, $user_id);
    } else {
        // No new profile picture uploaded, update other fields only
        $update_sql = "UPDATE users SET firstname = ?, lastname = ?, country = ?, phone = ?, DOB = ?, address = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        if ($update_stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $update_stmt->bind_param("ssssssi", $firstname, $lastname, $country, $phone, $dob, $address, $user_id);
    }

    // Execute the update statement
    if ($update_stmt->execute()) {
        echo "<script>alert('Profile updated successfully!');</script>";
        // Using header("Refresh:0") is generally discouraged. A simple header("Location: current_page.php"); is better
        // if you want to refresh and avoid form resubmission warnings.
        header("refresh:1; url=account-settings.php"); // Replace profile.php with your actual profile page
        exit(); // Always call exit after header redirects
    } else {
        echo "<script>alert('Error updating profile: " . htmlspecialchars($update_stmt->error) . "');</script>";
        // For debugging, you might want to log $conn->error or $update_stmt->error
    }

    // Close the statement
    $update_stmt->close();
}

if(isset($_POST['update_password'])){
	$current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current password hash from database
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($db_password);
    $stmt->fetch();
    $stmt->close();

    // Verify old password
    if (!password_verify($current_password, $db_password)) {
        echo "<script>alert('Old password is incorrect!');</script>";
    } elseif ($new_password !== $confirm_password) {
        echo "<script>alert('New passwords do not match!');</script>";
    } else {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password in database
        $update_sql = "UPDATE users SET password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo "<script>alert('Password updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating password. Please try again.');</script>";
        }

        $update_stmt->close();
    }
}
?>
            <!-- Page content -->
            <div class="page-content">
                    <!-- Page title -->
    <div class="page-title mt-5 mb-3 my-md-5">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Account Settings</h5>
            </div>
        </div>
    </div>
    <div>
    </div>	<div>
    </div>	<div>
    </div>    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-none">
                <div class="card-body">
					<div class="row profile">
                        <div class="p-2 col-md-12 p-md-4">
							<ul class="mb-4 nav nav-pills">
								<li class="nav-item">
									<a href="#per" class="nav-link active" data-toggle="tab">Personal Settings</a>
								</li>
								<!--<li class="nav-item">-->
								<!--	<a href="#set" class="nav-link" data-toggle="tab">Withdrawal Settings</a>-->
								<!--</li>-->
								<li class="nav-item">
									<a href="#pas" class="nav-link" data-toggle="tab">Password/Security</a>
								</li>
								<!--<li class="nav-item">-->
								<!--	<a href="#sec" class="nav-link" data-toggle="tab">Other Settings</a>-->
								<!--</li>-->
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade show active" id="per">
									<form method="POST" action="" id="updateprofileform" enctype="multipart/form-data">
                                        <input type="hidden" name="csrfmiddlewaretoken" value="4Ne4RvrX7ZYy1dGqYN0jDYp0YtZ4iwwXdOOrz3mX5JRM5wvLDfNolW4sqYLjFjJY">
        <div class="form-row">
          <div class="form-group col-md-6">
            <img height="150px" width="150px" src="uploads/<?php echo $user['profilePic']; ?>" alt="image" />
            <input type="file" class="form-control " name="profile">
        </div>
        <div class="form-group col-md-6">
            <label class="">Firstname</label>
            <input type="text" class="form-control " value="<?php  echo $user['firstname']; ?>" name="firstname">
        </div>
          <div class="form-group col-md-6">
            <label class="">Lastname</label>
            <input type="text" class="form-control " value="<?php  echo $user['lastname']; ?>" name="lastname">
        </div>
        <div class="form-group col-md-6">
            <label class="">Email Address</label>
            <input type="email" class="form-control " value="<?php  echo $user['email']; ?>" name="email" readonly>
        </div>
        <div class="form-group col-md-6">
            <label class="">Phone Number</label>
            <input type="text" class="form-control " value="<?php  echo $user['phone']; ?>" name="phone_number">
        </div>
        <div class="form-group col-md-6">
            <label class="">Date of Birth</label>
            <input type="date" value="<?php  echo $user['dob']; ?>" class="form-control " name="dob">
        </div>
        <div class="form-group col-md-6">
            <label class="">Country</label>
            <input type="text" value="<?php  echo $user['country']; ?>" class="form-control " name="country">
        </div>
        <div class="form-group col-md-6">
            <label class="">Address</label>
            <textarea class="form-control " placeholder="Full Address" name="address" row="3"><?php  echo $user['address']; ?></textarea>
        </div>

    </div>
    <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
</form>

<script>
    document.getElementById('updateprofileform').addEventListener('submit', function() {
        //alert('love');
        $.ajax({
            url: "",
            type: 'POST',
            data: $('#updateprofileform').serialize(),
            success: function(response) {
                if (response.status === 200) {
                    $.notify({
                        // options
                        icon: 'flaticon-alarm-1',
                        title: 'Success',
                        message: response.success,
                    }, {
                        // settings
                        type: 'success',
                        allow_dismiss: true,
                        newest_on_top: false,
                        showProgressbar: true,
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1031,
                        delay: 5000,
                        timer: 1000,
                        url_target: '_blank',
                        mouse_over: null,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        },

                    });
                } else {

                }
            },
            error: function(data) {
                console.log(data);
            },

        });
    });
</script>
    </div>
    <div class="tab-pane fade" id="set">
        <form method="post" action="javascript:void(0)" id="updatewithdrawalinfo">
            <input type="hidden" name="csrfmiddlewaretoken" value="4Ne4RvrX7ZYy1dGqYN0jDYp0YtZ4iwwXdOOrz3mX5JRM5wvLDfNolW4sqYLjFjJY">
    <input type="hidden" name="_method" value="PUT">
    <fieldset>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="">Bank Name</label>
                <input type="text" name="bank_name" value=""  class="form-control " placeholder="Enter bank name">
            </div>
            <div class="form-group col-md-6">
                <label class="">Account Name</label>
                <input type="text" name="account_name" value=""  class="form-control " placeholder="Enter Account name">
            </div>
            <div class="form-group col-md-6">
                <label class="">Account Number</label>
                <input type="text" name="account_no" value=""  class="form-control " placeholder="Enter Account Number">
            </div>
            <div class="form-group col-md-6">
                <label class="">Swift Code</label>
                <input type="text" name="swiftcode" value=""  class="form-control " placeholder="Enter Swift Code">
            </div>
        </div>
    </fieldset>
    <fieldset class="mt-2">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="">Bitcoin</label>
                <input type="text" name="btc_address" value=""  class="form-control " placeholder="Enter Bitcoin Address">
                <small class="">Enter your Bitcoin Address that will be used to withdraw your funds</small>
            </div>
            <div class="form-group col-md-6">
                <label class="">Ethereum</label>
                <input type="text" name="eth_address" value=""  class="form-control " placeholder="Enter Etherium Address">
                <small class="">Enter your Ethereum Address that will be used to withdraw your funds</small>
            </div>
            <div class="form-group col-md-6">
                <label class="">Litecoin</label>
                <input type="text" name="ltc_address" value=""  class="form-control " placeholder="Enter Litcoin Address">
                <small class="">Enter your Litecoin Address that will be used to withdraw your funds</small>
            </div>
        </div>
    </fieldset>
    <button type="submit" class="px-5 btn btn-primary">Save</button>
</form>


<script>
    
    document.getElementById('updatewithdrawalinfo').addEventListener('submit', function() {
       // alert('love');
        $.ajax({
            url: "https://app.teslaquantumtrade.com/dashboard/updateacct",
            type: 'POST',
            data: $('#updatewithdrawalinfo').serialize(),
            success: function(response) {
                if (response.status === 200) {
                    $.notify({
                        // options
                        icon: 'flaticon-alarm-1',
                        title: 'Success',
                        message: response.success,
                    },{
                        // settings
                        type: 'success',
                        allow_dismiss: true,
                        newest_on_top: false,
                        showProgressbar: true,
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1031,
                        delay: 5000,
                        timer: 1000,
                        url_target: '_blank',
                        mouse_over: null,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        },
    
                    });
                } else {
                   
                }
            },
            error: function(data) {
                console.log(data);
            },
    
        });
    });
</script>								</div>
    <div class="tab-pane fade" id="pas">
        <form method="POST" action="">
            <input type="hidden" name="csrfmiddlewaretoken" value="4Ne4RvrX7ZYy1dGqYN0jDYp0YtZ4iwwXdOOrz3mX5JRM5wvLDfNolW4sqYLjFjJY">
        <input type="hidden" name="_method" value="PUT">    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="">Old Password</label>
            <input type="password" name="current_password" class="form-control " required>
        </div>
        <div class="form-group col-md-6">
            <label class="">New Password</label>
            <input type="password" name="new_password" class="form-control " required>
        </div>
        <div class="form-group col-md-6">
            <label class="">Confirm New Password</label>
            <input type="password" name="confirm_password" class=" form-control" required>
        </div>
    </div>
    <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
</form>
<!--<div class="mt-4">-->
<!--    <a href="https://app.teslaquantumtrade.com/dashboard/manage-account-security" class="text-decoration-none">Advance Account Settings <i class="fas fa-arrow-right"></i> </a>-->
<!--</div>-->								</div>
								<div class="tab-pane fade" id="sec">
									<form method="POST" action="javascript:void(0)" id="updateemailpref">
    <input type="hidden" name="_token" value="DwT5c6Zsf4pO0gBQPkbrDWcBnfPNop8qMUS0bkwa">    <input type="hidden" name="_method" value="PUT">    <div class="row">
        <div class="mb-3 col-md-6">
            <label class="">Send confirmation OTP to my email when withdrawing my funds.</label>
            <div class="selectgroup">
                <label class="selectgroup-item">
                    <input type="radio" name="otpsend" id="otpsendYes" value="Yes" class="selectgroup-input" checked="">
                    <span class="selectgroup-button">Yes</span>
                </label>
                <label class="selectgroup-item">
                    <input type="radio" name="otpsend" id="otpsendNo" value="No" class="selectgroup-input">
                    <span class="selectgroup-button">No</span>
                </label>
            </div>
        </div>
        
        <div class="mb-3 col-md-6">
            <label class="">Send me email when i get profit.</label>
            <div class="selectgroup">
                <label class="selectgroup-item">
                    <input type="radio" name="roiemail" id="roiemailYes" value="Yes" class="selectgroup-input" checked="">
                    <span class="selectgroup-button">Yes</span>
                </label>
                <label class="selectgroup-item">
                    <input type="radio" name="roiemail" id="roiemailNo" value="No" class="selectgroup-input">
                    <span class="selectgroup-button">No</span>
                </label>
            </div>
        </div>
        <div class="mb-3 col-md-6">
            <label class="">Send me email when my investment plan expires.</label>
            <div class="selectgroup">
                <label class="selectgroup-item">
                    <input type="radio" name="invplanemail" id="invplanemailYes" value="Yes" class="selectgroup-input" checked="">
                    <span class="selectgroup-button">Yes</span>
                </label>
                <label class="selectgroup-item">
                    <input type="radio" name="invplanemail" id="invplanemailNo" value="No" class="selectgroup-input">
                    <span class="selectgroup-button">No</span>
                </label>
            </div>
        </div>
        <div class="mt-2 col-12">
            <button type="submit" class="px-5 btn btn-primary">Save</button>
        </div>
    </div>
    
</form>



<script>
    document.getElementById('otpsendNo').checked = true;
</script> 





    <script>
        document.getElementById('roiemailYes').checked = true;
    </script>    


    <script>
        document.getElementById('invplanemailYes').checked = true;
    </script>    



<script>
    
    document.getElementById('updateemailpref').addEventListener('submit', function() {
       // alert('love');
        $.ajax({
            url: "https://app.teslaquantumtrade.com/dashboard/update-email-preference",
            type: 'POST',
            data: $('#updateemailpref').serialize(),
            success: function(response) {
                if (response.status === 200) {
                    $.notify({
                        // options
                        icon: 'flaticon-alarm-1',
                        title: 'Success',
                        message: response.success,
                    },{
                        // settings
                        type: 'success',
                        allow_dismiss: true,
                        newest_on_top: false,
                        showProgressbar: true,
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 1031,
                        delay: 5000,
                        timer: 1000,
                        url_target: '_blank',
                        mouse_over: null,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        },
    
                    });
                } else {
                   
                }
            },
            error: function(data) {
                console.log(data);
            },
    
        });
    });
</script>								</div>
							</div>
                        </div>
					</div>
                </div>
            </div>
        </div>
	</div>
	
            </div>
            <?php include('footer.php'); ?>