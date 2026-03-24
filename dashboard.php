<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])) header("Location: index.php");

$user_id = $_SESSION['user_id'];
$res = $conn->query("SELECT * FROM entries WHERE user_id=$user_id ORDER BY id DESC LIMIT 10");
?>

<link rel="stylesheet" href="assets/style.css">

<div class="navbar">
    <div>Diary.com</div>
    <div>
        <a href="calendar.php">Calendar</a>
        <a href="add_entry.php">Add</a>
        <a href="feed.php">Feed</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
<h2>Dashboard</h2>

<?php while($row=$res->fetch_assoc()){ ?>
<div class="card">
    <div class="card-header">
        <h3><?php echo $row['title']; ?></h3>
        <span class="time"><?php echo date("d M Y, h:i A", strtotime($row['date'])); ?></span>
    </div>
    <p><?php echo $row['content']; ?></p>
    <div class="card-actions">
        <a class="edit-btn" href="edit_entry.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a class="delete-btn" href="delete_entry.php?id=<?php echo $row['id']; ?>">Delete</a>
    </div>
</div>
<?php } ?>
</div>