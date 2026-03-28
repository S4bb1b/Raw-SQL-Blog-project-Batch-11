

<?php
include 'db.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?msg=success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone">
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
</form>