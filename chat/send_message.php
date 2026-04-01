<?php
session_start();
include '../config/db.php';

$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];
$book_id = $_POST['book_id'];
$message = $_POST['message'];

mysqli_query($conn, "INSERT INTO messages (sender_id, receiver_id, book_id, message)
VALUES ('$sender_id', '$receiver_id', '$book_id', '$message')");
?>