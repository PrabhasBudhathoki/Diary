<?php
session_start();
include(__DIR__ . "/config/db.php");

$user_id = $_SESSION['user_id'];
$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");

// Count check
$count = $conn->query("SELECT * FROM entries WHERE user_id=$user_id AND date='$date'")->num_rows;
if ($count >= 3) { echo "Limit reached for this day"; exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $public = isset($_POST['public']) ? 1 : 0;

    $conn->query("INSERT INTO entries(user_id,title,content,date,is_public) VALUES($user_id,'$title','$content','$date',$public)");
    header("Location: dashboard.php");
    exit;
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="navbar">
    <div>Diary.com</div>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="calendar.php">Calendar</a>
        <a href="feed.php">Feed</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Add Entry</h2>
    <form method="POST">
    <input name="title" placeholder="Title" required>
    <textarea name="content" placeholder="Write here..." required></textarea>

    <div class="checkbox-group">
        <input type="checkbox" name="public" value="1">
        <label>Public</label>
    </div>

    <button>Add Entry</button>
</form>
</div>