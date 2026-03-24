<?php
session_start();
include("config/db.php");

// Redirect to login if not logged in
if(!isset($_SESSION['user_id']) || $_SESSION['user_id']=="") {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

$res = $conn->query("SELECT date FROM entries WHERE user_id=$user_id");
$dates = [];
while($row = $res->fetch_assoc()) $dates[] = $row['date'];

$title = date("F Y", strtotime("$year-$month-01"));
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>

<link rel="stylesheet" href="assets/style.css">

<div class="navbar">
    <div>Diary.com</div>
    <div>
        <a href="calendar.php">Calendar</a>
        <a href="add_entry.php">Add</a>
        <a href="feed.php">Feed</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
<h2>Calendar</h2>

<div class="month-year-nav">
    <a class="prev-next-btn" href="?month=<?php echo $month==1?12:$month-1; ?>&year=<?php echo $month==1?$year-1:$year; ?>">&lt; Prev</a>
    <span><?php echo $title; ?></span>
    <a class="prev-next-btn" href="?month=<?php echo $month==12?1:$month+1; ?>&year=<?php echo $month==12?$year+1:$year; ?>">Next &gt;</a>
</div>

<div class="grid">
<?php
for($i=1;$i<=$days_in_month;$i++){
    $d = sprintf("%04d-%02d-%02d",$year,$month,$i);
    $link = "add_entry.php?date=$d";
    $class = in_array($d,$dates) ? 'day highlight' : 'day';
    echo "<a href='$link' class='$class'>$i</a>";
}
?>
</div>
</div>