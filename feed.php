<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])) header("Location: index.php");

$res = $conn->query("SELECT e.*, u.username FROM entries e JOIN users u ON e.user_id=u.id WHERE e.is_public=1 ORDER BY e.id DESC");
?>

<link rel="stylesheet" href="assets/style.css">

<div class="navbar">
    <div>Diary.com</div>
    <div>
        <a href="calendar.php">Calendar</a>
        <a href="add_entry.php">Add</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
<h2>Feed</h2>

<?php while($row=$res->fetch_assoc()){ ?>
<div class="card">
    <div class="card-header">
        <h4><?php echo $row['username']; ?></h4>
        <span class="time"><?php echo date("d M Y, h:i A", strtotime($row['date'])); ?></span>
    </div>
    <p class="feed-title"><?php echo $row['title']; ?></p>
    <p><?php echo $row['content']; ?></p>
</div>
<?php } ?>
</div>