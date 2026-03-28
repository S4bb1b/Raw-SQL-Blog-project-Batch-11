

<?php
include 'db.php';
$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM blogs WHERE user_id = '$user_id'");
?>

<h2>My Blogs</h2>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['is_publish'] ? 'Published' : 'Unpublished'; ?></td>
        <td>
            <a href="view_blog.php?id=<?php echo $row['id']; ?>">View</a> |
            <a href="edit_blog.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a href="toggle_status.php?id=<?php echo $row['id']; ?>">Toggle Publish</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>