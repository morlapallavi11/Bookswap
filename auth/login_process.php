<?php
session_start();
include '../config/db.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['name'];

        header("Location: ../dashboard.php");
        exit();

    } else {
        echo "Incorrect Password";
    }

} else {
    echo "User not found";
}
?>
