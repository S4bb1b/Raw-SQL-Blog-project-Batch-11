
<?php
include 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); }

if (isset($_POST['create_blog'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $short_desc = $_POST['short_description'];
    $long_desc = $_POST['long_description'];
    $is_publish = isset($_POST['is_publish']) ? 1 : 0;
    
    // Image Upload Logic
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $query = "INSERT INTO blogs (user_id, title, short_description, long_description, image, is_publish) 
              VALUES ('$user_id', '$title', '$short_desc', '$long_desc', '$image', '$is_publish')";
    
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Blog Title" required>
    <textarea name="short_description" placeholder="Short Description"></textarea>
    <textarea name="long_description" placeholder="Long Description"></textarea>
    <input type="file" name="image">
    <label><input type="checkbox" name="is_publish"> Publish immediately?</label>
    <button type="submit" name="create_blog">Save Blog</button>
</form>