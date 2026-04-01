<?php
session_start();
include 'config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// user data
$res = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($res);

// user books
$books = mysqli_query($conn, "SELECT * FROM books WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f8; }
        .bookswap-title { font-weight: bold; font-size: 1.5rem; color: #fff; }
        .card { background-color: #fff; box-shadow: 0 3px 8px rgba(0,0,0,0.15); border-radius: 8px; }
    </style>
</head>

<body>

<!-- Navbar (same as other pages) -->
<nav class="navbar navbar-expand-lg shadow-sm px-4 py-3" style="background-color:#2c3e50;">
    <div class="container-fluid">
        <a class="navbar-brand bookswap-title" href="dashboard.php">📚 BookSwap</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="dashboard.php" class="nav-link text-white">Dashboard</a>
            <a href="auth/logout.php" class="btn btn-dark">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

<h2 class="mb-4 text-center">My Profile</h2>

<!-- Profile Card -->
<div class="card p-4 mb-4 text-center">

    <img src="uploads/<?php echo $user['profile_pic']; ?>" 
         style="width:120px; height:120px; border-radius:50%; object-fit:cover;">

    <h4 class="mt-3"><?php echo $user['name']; ?></h4>
    <p><?php echo $user['email']; ?></p>

    <a href="edit_profile.php" class="btn btn-warning">
        ✏️ Edit Profile
    </a>

</div>

<h4 class="mb-3">My Books</h4>

<div class="row">
<?php while($row = mysqli_fetch_assoc($books)) { ?>
    
    <div class="col-md-4 mb-4">
        <div class="card p-2">
            <img src="uploads/<?php echo $row['image']; ?>" 
                 style="height:200px; object-fit:cover;">
            
            <div class="p-2">
                <h5><?php echo $row['title']; ?></h5>
                <p><?php echo $row['author']; ?></p>
            </div>
        </div>
    </div>

<?php } ?>
</div>

</div>

<script src="assets/js/script.js"></script>
</body>
</html>