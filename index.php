<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Energy Monitoring</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="bg-animation"></div>

<div class="login-box">
    <h2>⚡ Energy Monitor</h2>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <div class="input-box">
            <input type="text" name="username" required>
            <label>Username</label>
        </div>

        <div class="input-box">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>

        <button type="submit" name="login">Login</button>
    </form>

    <p>New user? <a href="register.php">Register</a></p>
</div>

</body>
</html>