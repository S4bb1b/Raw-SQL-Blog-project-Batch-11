

<?php
include 'db.php';

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Fetch user by email
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Blog System</title>
    <style>
        .login-container { width: 300px; margin: 100px auto; font-family: sans-serif; border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
        .error { color: red; font-size: 0.9em; }
        input { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    
    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
        <p style="color: green;">Registration successful! Please login.</p>
    <?php endif; ?>

    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required placeholder="Enter your email">
        
        <label>Password:</label>
        <input type="password" name="password" required placeholder="Enter your password">
        
        <button type="submit" name="login">Login</button>
    </form>
    
    <p style="font-size: 0.9em; text-align: center;">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>

</body>
</html>