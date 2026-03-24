<?php
session_start();
include(__DIR__ . "/config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch the entry for this user
$res = $conn->query("SELECT * FROM entries WHERE id=$id AND user_id=$user_id");
$row = $res->fetch_assoc();

// If entry not found, redirect to dashboard
if (!$row) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $conn->query("UPDATE entries SET title='$title', content='$content' WHERE id=$id AND user_id=$user_id");
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
        <a href="add_entry.php">Add</a>
        <a href="feed.php">Feed</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Edit Journal Entry</h2>

    <div class="card">
        <form method="POST">
            <label>Title</label>
            <input name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>

            <label>Content</label>
            <textarea name="content" rows="6" required><?php echo htmlspecialchars($row['content']); ?></textarea>

            <button>Update Entry</button>
        </form>
    </div>
</div>