<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body>

<div class="container-custom">

    <!-- LEFT SIDE -->
    <div class="left">

        <h1>BookSwap</h1>
        <p>Swap your books for exciting new reads</p>

        <form action="login_process.php" method="POST">

            <input type="email" name="email" placeholder="Enter your email..." required>

            <input type="password" name="password" placeholder="Enter your password..." required>

            <button type="submit">Login</button>

        </form>

        <div class="link">
            Don't have an account? <a href="register.php">Register</a>
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <img src="../assets/images/phones.png" style="width:350px;">
    </div>

</div>

</body>
</html>