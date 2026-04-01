<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f8; }
        .bookswap-title { font-weight: bold; font-size: 1.5rem; color: #fff; }
        .card { background-color: #fff; box-shadow: 0 3px 8px rgba(0,0,0,0.15); padding: 20px; border-radius: 8px; }
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

<div class="container mt-5">
    <h2 class="mb-4 text-center">Add a New Book</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form action="add_book_process.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Book Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Author</label>
                        <input type="text" name="author" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Genre</label>
                        <input type="text" name="genre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Book Condition</label>
                        <select name="book_condition" class="form-control" required>
                            <option value="New">New</option>
                            <option value="Good">Good</option>
                            <option value="Old">Old</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Book Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Add Book</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>