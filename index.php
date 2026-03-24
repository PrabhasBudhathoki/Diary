<?php
session_start();
include("config/db.php");

// Handle form submission
$error = "";
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if(isset($_POST['signup'])) {
        // Signup process
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("INSERT INTO users(username,email,password) VALUES('$username','$email','$pass')");
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        header("Location: calendar.php");
        exit;
    }

    if(isset($_POST['login'])) {
        $res = $conn->query("SELECT * FROM users WHERE email='$email'");
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            if(password_verify($password, $row['password'])){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: calendar.php");
                exit;
            } else $error = "Incorrect password";
        } else $error = "User not found";
    }
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="login-container">
    <h1>Diary.com</h1>
    <?php if($error!="") echo "<p class='error'>$error</p>"; ?>
    <form method="POST" class="login-form">
        <input type="text" name="username" placeholder="Username (for signup)" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="button-group">
            <button type="submit" name="login">Login</button>
            <button type="submit" name="signup">Signup</button>
        </div>
    </form>
</div>