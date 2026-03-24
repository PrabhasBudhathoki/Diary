<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include(__DIR__ . "/config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username']; // optional
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($conn->query("INSERT INTO users(email, password) VALUES('$email','$pass')")) {
        $user_id = $conn->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['is_admin'] = 0; // default normal user
        header("Location: dashboard.php"); // redirect directly to dashboard
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<link rel="stylesheet" href="assets/style.css">
<div class="login-container">
    <h1>Diary.com - Signup</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username (optional)">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Signup</button>
    </form>
    <a href="index.php">Login</a>
</div>