<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit;
}
include 'db.php';

// Fetch consumption data
$stmt = $conn->prepare("SELECT * FROM consumption WHERE user_id=:user_id");
$stmt->execute(['user_id'=>$_SESSION['user_id']]);
$consumption = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"><title>Dashboard</title></head>
<body>
<h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
<a href="add_appliance.php">Add Appliance Usage</a> | <a href="calculate_bill.php">Calculate Bill</a> | <a href="logout.php">Logout</a>
<hr>
<h3>Your Consumption Data:</h3>
<table border="1">
<tr><th>Appliance</th><th>Hours Used</th><th>Power Rating (W)</th><th>Date</th></tr>
<?php foreach($consumption as $row): ?>
<tr>
    <td><?php echo $row['appliance_name']; ?></td>
    <td><?php echo $row['usage_hours']; ?></td>
    <td><?php echo $row['power_rating']; ?></td>
    <td><?php echo $row['usage_date']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>