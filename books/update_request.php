<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    echo "Login required";
    exit();
}

// FIX: correct parameter name
$request_id = $_GET['id'];  
$action = $_GET['action'];

// get request details
$res = mysqli_query($conn, "SELECT * FROM requests WHERE id='$request_id'");
$row = mysqli_fetch_assoc($res);

// FIX: correct columns
$book_id = $row['book_id'];
$requester_id = $row['requester_id'];

if($action == "approve"){
    mysqli_query($conn, "UPDATE requests SET status='Approved' WHERE id='$request_id'");
    
    // redirect to chat (owner → requester)
    header("Location: ../chat/chat.php?user_id=$requester_id&book_id=$book_id");
    exit();
}

if($action == "reject"){
    mysqli_query($conn, "UPDATE requests SET status='Rejected' WHERE id='$request_id'");
    header("Location: view_requests.php");
    exit();
}
?>