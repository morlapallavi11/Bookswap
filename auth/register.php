
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body>

<div class="container-custom">

    <!-- LEFT -->
    <div class="left">
        <h1>Join BookSwap</h1>
        <p>Create account and start swapping books</p>

        <form action="register_process.php" method="POST">
            <input type="text" name="name" placeholder="Enter your name..." required>
            <input type="email" name="email" placeholder="Enter your email..." required>
            <input type="password" name="password" placeholder="Enter password..." required>

            <button type="submit">Register</button>
        </form>

        <div class="link">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <img src="../assets/images/phones.png"style="width:350px;">
    </div>

</div>

</body>
</html>