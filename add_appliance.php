<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])) header("Location: index.php");

if(isset($_POST['add'])){
    $appliance = $_POST['appliance'];
    $hours = $_POST['hours'];
    $power = $_POST['power'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO consumption (user_id, appliance_name, usage_hours, power_rating, usage_date) VALUES (:user_id, :appliance, :hours, :power, :date)");
    $stmt->execute([
        'user_id'=>$_SESSION['user_id'],
        'appliance'=>$appliance,
        'hours'=>$hours,
        'power'=>$power,
        'date'=>$date
    ]);
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"><title>Add Appliance</title></head>
<body>
<h2>Add Appliance Usage</h2>
<form method="POST">
    <input type="text" name="appliance" placeholder="Appliance Name" required><br><br>
    <input type="number" step="0.1" name="hours" placeholder="Hours Used" required><br><br>
    <input type="number" step="0.1" name="power" placeholder="Power Rating (W)" required><br><br>
    <input type="date" name="date" required><br><br>
    <button type="submit" name="add">Add</button>
</form>
</body>
</html>