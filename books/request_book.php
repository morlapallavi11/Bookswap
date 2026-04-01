<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$requester_id = $_SESSION['user_id'];
$book_id = $_GET['book_id'];
$owner_id = $_GET['owner_id'];

// prevent requesting own book
if ($requester_id == $owner_id) {
    $message = "You cannot request your own book!";
} else {
    // insert request
    $sql = "INSERT INTO requests (book_id, requester_id, owner_id, status)
            VALUES ('$book_id', '$requester_id', '$owner_id', 'Pending')";
    if ($conn->query($sql) === TRUE) {
        $message = "Book request sent successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f8; }
        .bookswap-title { font-weight: bold; font-size: 1.5rem; color: #fff; }
        .card { background-color: #fff; box-shadow: 0 3px 8px rgba(0,0,0,0.15); padding: 20px; border-radius: 8px; margin-top: 50px; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm px-4 py-3" style="background-color:#2c3e50;">
    <div class="container-fluid">
        <a class="navbar-brand bookswap-title" href="../dashboard.php">📚 BookSwap</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="../dashboard.php" class="nav-link text-white">Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-dark">Logout</a>
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center">
    <div class="card text-center">
        <h4><?php echo $message; ?></h4>
        <a href="view_books.php" class="btn btn-primary mt-3">Back to Books</a>
        <a href="my_requests.php" class="btn btn-secondary mt-3">My Requests</a>
    </div>
</div>

</body>
</html>