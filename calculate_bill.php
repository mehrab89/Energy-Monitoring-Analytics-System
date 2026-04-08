<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])) header("Location: index.php");

// Fetch user consumption
$stmt = $conn->prepare("SELECT * FROM consumption WHERE user_id=:user_id");
$stmt->execute(['user_id'=>$_SESSION['user_id']]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_kwh = 0;
foreach($data as $d){
    $total_kwh += ($d['usage_hours'] * $d['power_rating']) / 1000; // kWh
}

$rate = 10; // per kWh
$total_bill = $total_kwh * $rate;

// Store prediction
$stmt = $conn->prepare("INSERT INTO predictions (user_id, predicted_bill, prediction_date) VALUES (:user_id, :bill, CURDATE())");
$stmt->execute(['user_id'=>$_SESSION['user_id'], 'bill'=>$total_bill]);

?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"><title>Bill</title></head>
<body>
<h2>Bill & Prediction</h2>
<p>Total Energy Consumed: <?php echo $total_kwh; ?> kWh</p>
<p>Predicted Bill: $<?php echo $total_bill; ?></p>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>