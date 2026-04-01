<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['submit'])){
    $message = $_POST['message'];

    mysqli_query($conn, "
        INSERT INTO testimonials(user_id, message) 
        VALUES('$user_id', '$message')
    ");

    header("Location: ../dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Testimonial</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="container mt-5">

<h3>Add Your Review</h3>

<form method="POST">
    <textarea name="message" class="form-control mb-3" placeholder="Write your experience..." required></textarea>
    <button type="submit" name="submit" class="btn btn-dark">Submit</button>
</form>

</body>
</html>