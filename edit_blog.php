

<?php
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$blog_id = $_GET['id'];

// 1. Fetch existing blog data to pre-fill the form
$query = "SELECT * FROM blogs WHERE id = '$blog_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$blog = mysqli_fetch_assoc($result);

if (!$blog) {
    die("Blog not found or you don't have permission to edit it.");
}

// 2. Handle the Update Logic
if (isset($_POST['update_blog'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $short_desc = mysqli_real_escape_string($conn, $_POST['short_description']);
    $long_desc = mysqli_real_escape_string($conn, $_POST['long_description']);
    $is_publish = isset($_POST['is_publish']) ? 1 : 0;

    // Handle Image Upload (Optional: only update if a new file is chosen)
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        
        // Update query with new image
        $update_query = "UPDATE blogs SET 
            title = '$title', 
            short_description = '$short_desc', 
            long_description = '$long_desc', 
            image = '$image', 
            is_publish = '$is_publish' 
            WHERE id = '$blog_id' AND user_id = '$user_id'";
    } else {
        // Update query keeping the old image
        $update_query = "UPDATE blogs SET 
            title = '$title', 
            short_description = '$short_desc', 
            long_description = '$long_desc', 
            is_publish = '$is_publish' 
            WHERE id = '$blog_id' AND user_id = '$user_id'";
    }

    if (mysqli_query($conn, $update_query)) {
        header("Location: dashboard.php?msg=updated");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog</title>
</head>
<body>
    <h2>Edit Blog Post</h2>
    <a href="dashboard.php">Back to Dashboard</a>
    <hr>

    <form method="POST" enctype="multipart/form-data">
        <div>
            <label>Title:</label><br>
            <input type="text" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required style="width: 100%;">
        </div><br>

        <div>
            <label>Short Description:</label><br>
            <textarea name="short_description" rows="3" style="width: 100%;"><?php echo htmlspecialchars($blog['short_description']); ?></textarea>
        </div><br>

        <div>
            <label>Long Description:</label><br>
            <textarea name="long_description" rows="10" style="width: 100%;"><?php echo htmlspecialchars($blog['long_description']); ?></textarea>
        </div><br>

        <div>
            <label>Current Image:</label><br>
            <img src="uploads/<?php echo $blog['image']; ?>" width="150"><br>
            <label>Change Image (Leave blank to keep current):</label><br>
            <input type="file" name="image">
        </div><br>

        <div>
            <label>
                <input type="checkbox" name="is_publish" <?php echo $blog['is_publish'] ? 'checked' : ''; ?>> 
                Published
            </label>
        </div><br>

        <button type="submit" name="update_blog">Update Blog</button>
    </form>
</body>
</html>