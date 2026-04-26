<?php
// This file assumes a database connection is established in includes/header.php
// and the $conn variable is available.
include "includes/header.php";

$message = "";

// Function to handle file uploads
function handle_file_upload($file_key, $upload_dir) {
    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES[$file_key]['tmp_name'];
        $file_name = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES[$file_key]['name']));
        $dest_path = $upload_dir . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp_path, $dest_path)) {
            return $dest_path;
        }
    }
    return null;
}

// Function to delete old file
function delete_old_file($file_path) {
    if ($file_path && file_exists($file_path)) {
        unlink($file_path);
    }
}

// Determine the action
$action = $_GET['action'] ?? 'list';

// Handle POST requests for adding and updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize all form data
    $content = $_POST['content'] ?? '';
    $author_name = $_POST['author_name'] ?? '';
    $author_profile_link = $_POST['author_profile_link'] ?? '';
    $followers = $_POST['followers'] ?? 0;

    // Handle author image upload
    $author_image_path = handle_file_upload('author_image', 'uploads/');
    if ($author_image_path === null) {
        $author_image_path = $_POST['existing_author_image'] ?? null;
    } else {
        delete_old_file($_POST['existing_author_image'] ?? null);
    }

    if (isset($_POST['add_article'])) {
        $sql = "INSERT INTO reviews (content, author_name, author_image_url, author_profile_link, followers) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $content, $author_name, $author_image_path, $author_profile_link, $followers);
            
            if (mysqli_stmt_execute($stmt)) {
                $message = '<div class="alert alert-success">Review added successfully!</div>';
                $action = 'list';
            } else {
                $message = '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
                $action = 'add';
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $message = '<div class="alert alert-danger">Error preparing statement: ' . mysqli_error($conn) . '</div>';
            $action = 'add';
        }

    } elseif (isset($_POST['update_article'])) {
        $id = (int)($_POST['article_id'] ?? 0);
        
        $sql = "UPDATE reviews SET content = ?, author_name = ?, author_image_url = ?, author_profile_link = ?, followers = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssi", $content, $author_name, $author_image_path, $author_profile_link, $followers, $id);
            
            if (mysqli_stmt_execute($stmt)) {
                $message = '<div class="alert alert-success">Review updated successfully!</div>';
                $action = 'list';
            } else {
                $message = '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
                $action = 'edit';
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $message = '<div class="alert alert-danger">Error preparing statement: ' . mysqli_error($conn) . '</div>';
            $action = 'edit';
        }
    }
} elseif ($action === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Get author_image_url for deleting the file
    $sql_select = "SELECT author_image_url FROM reviews WHERE id = ?";
    $stmt_select = mysqli_prepare($conn, $sql_select);
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);
    $review_to_delete = mysqli_fetch_assoc($result_select);
    mysqli_stmt_close($stmt_select);

    if ($review_to_delete) {
        delete_old_file($review_to_delete['author_image_url']);

        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                $message = '<div class="alert alert-success">Review deleted successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = '<div class="alert alert-danger">Error preparing statement: ' . mysqli_error($conn) . '</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Review not found.</div>';
    }
    
    header("Location: addReview.php");
    exit();
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Reviews Management <small>Control panel</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reviews</li>
        </ol>
    </section>

    <section class="content">
        <?php echo $message; ?>

        <?php if ($action === 'list') { ?>
            <div class="box-body">
                <div class="overflow-x-auto">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Author</th>
                                <th>Followers</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT id, author_name, followers FROM reviews ORDER BY created_at DESC";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                                        <td><?php echo $row['followers']; ?></td>
                                        <td>
                                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs">Edit</a>
                                            <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='4'>No reviews found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <a href="?action=add" class="btn btn-success" style="margin-top: 10px;">Add New Review</a>
            </div>

        <?php } elseif ($action === 'add' || $action === 'edit') { ?>
            <?php
            $article_id = '';
            $article_content = '';
            $article_author_name = '';
            $article_author_image_url = '';
            $article_author_profile_link = '';
            $article_followers = '';
            
            $form_action_url = '?action=add';
            $form_heading = 'Add New Review';
            $submit_name = 'add_article';
            $submit_text = 'Add Review';

            if ($action === 'edit' && isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                $sql = "SELECT * FROM reviews WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $review = mysqli_fetch_assoc($result);
                    $article_id = htmlspecialchars($review['id']);
                    $article_content = htmlspecialchars($review['content']);
                    $article_author_name = htmlspecialchars($review['author_name']);
                    $article_author_image_url = htmlspecialchars($review['author_image_url']);
                    $article_author_profile_link = htmlspecialchars($review['author_profile_link']);
                    $article_followers = htmlspecialchars($review['followers']);
                    
                    $form_action_url = '?action=edit&id=' . $article_id;
                    $form_heading = 'Edit Review';
                    $submit_name = 'update_article';
                    $submit_text = 'Update Review';
                }
                mysqli_stmt_close($stmt);
            }
            ?>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $form_heading; ?></h3>
                </div>
                <form action="<?php echo $form_action_url; ?>" method="post" role="form" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="author_name">Author Name</label>
                            <input type="text" name="author_name" id="author_name" class="form-control" value="<?php echo $article_author_name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="author_profile_link">Author Profile Link</label>
                            <input type="url" name="author_profile_link" id="author_profile_link" class="form-control" value="<?php echo $article_author_profile_link; ?>">
                        </div>
                        <div class="form-group">
                            <label for="followers">Followers</label>
                            <input type="text" name="followers" id="followers" class="form-control" value="<?php echo $article_followers; ?>">
                        </div>
                        <div class="form-group">
                            <label for="author_image">Author Image</label>
                            <input type="file" name="author_image" id="author_image" class="form-control" required>
                            <?php if ($article_author_image_url): ?>
                                <p class="help-block">Current Author Image: <a href="<?php echo htmlspecialchars($article_author_image_url); ?>" target="_blank">View</a></p>
                                <input type="hidden" name="existing_author_image" value="<?php echo htmlspecialchars($article_author_image_url); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="content">Review Content</label>
                            <textarea name="content" id="content" class="form-control" rows="10" required><?php echo $article_content; ?></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
                        <button name="<?php echo $submit_name; ?>" type="submit" class="btn btn-primary"><?php echo $submit_text; ?></button>
                        <a href="addReview.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        <?php } ?>
    </section>
</div>
<?php
mysqli_close($conn);
include "includes/footer.php";
?>
