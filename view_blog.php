

<?php
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];
$blog_id = $_GET['id'];

// 1. Fetch Blog Details with Author Name
$blog_query = "SELECT blogs.*, users.name as author_name 
               FROM blogs 
               JOIN users ON blogs.user_id = users.id 
               WHERE blogs.id = '$blog_id'";
$blog_result = mysqli_query($conn, $blog_query);
$blog = mysqli_fetch_assoc($blog_result);

if (!$blog) {
    die("Blog post not found.");
}

// 2. Handle New Comment Submission
if (isset($_POST['post_comment'])) {
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);
    
    if (!empty($comment_text)) {
        $insert_comment = "INSERT INTO comments (blog_id, user_id, comment) 
                          VALUES ('$blog_id', '$current_user_id', '$comment_text')";
        mysqli_query($conn, $insert_comment);
        header("Location: view_blog.php?id=$blog_id"); // Refresh to show new comment
        exit();
    }
}

// 3. Fetch All Comments for this Blog
$comments_query = "SELECT comments.*, users.name as commenter_name 
                   FROM comments 
                   JOIN users ON comments.user_id = users.id 
                   WHERE blog_id = '$blog_id' 
                   ORDER BY created_at DESC";
$comments_result = mysqli_query($conn, $comments_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
    <style>
        .blog-container { width: 70%; margin: auto; font-family: Arial, sans-serif; }
        .comment-box { background: #f9f9f9; padding: 10px; margin-bottom: 10px; border-left: 5px solid #ccc; }
        .comment-meta { font-size: 0.8em; color: #666; }
        .status-badge { padding: 5px; color: white; border-radius: 3px; }
        .published { background: green; } .unpublished { background: red; }
    </style>
</head>
<body>

<div class="blog-container">
    <a href="dashboard.php">← Back to Dashboard</a>
    <hr>

    <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
    <p><strong>By:</strong> <?php echo htmlspecialchars($blog['author_name']); ?> | 
       <strong>Date:</strong> <?php echo $blog['created_at']; ?> |
       <span class="status-badge <?php echo $blog['is_publish'] ? 'published' : 'unpublished'; ?>">
           <?php echo $blog['is_publish'] ? 'Published' : 'Unpublished'; ?>
       </span>
    </p>

    <?php if($blog['image']): ?>
        <img src="uploads/<?php echo $blog['image']; ?>" style="max-width: 100%; height: auto; border: 1px solid #ddd;">
    <?php endif; ?>

    <h3>Summary</h3>
    <p><em><?php echo nl2br(htmlspecialchars($blog['short_description'])); ?></em></p>

    <hr>
    <h3>Content</h3>
    <p><?php echo nl2br(htmlspecialchars($blog['long_description'])); ?></p>

    <hr>
    <h2>Comments</h2>

    <form method="POST">
        <textarea name="comment_text" placeholder="Write a comment..." rows="4" style="width: 100%;" required></textarea><br><br>
        <button type="submit" name="post_comment">Post Comment</button>
    </form>

    <br>

    <?php if(mysqli_num_rows($comments_result) > 0): ?>
        <?php while($comment = mysqli_fetch_assoc($comments_result)): ?>
            <div class="comment-box">
                <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                <div class="comment-meta">
                    Posted by <strong><?php echo htmlspecialchars($comment['commenter_name']); ?></strong> 
                    on <?php echo $comment['created_at']; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>
</div>

</body>
</html>