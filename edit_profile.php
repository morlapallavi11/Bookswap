<?php
session_start();
include 'config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// get user data
$res = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($res);

// update profile
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];

    // IMAGE UPLOAD
    if(!empty($_FILES['profile_pic']['name'])){
        $image = $_FILES['profile_pic']['name'];
        $tmp = $_FILES['profile_pic']['tmp_name'];

        $new_name = time() . "_" . $image;
        move_uploaded_file($tmp, "uploads/" . $new_name);

        mysqli_query($conn, "UPDATE users 
            SET name='$name', email='$email', profile_pic='$new_name' 
            WHERE id='$user_id'");
    } else {
        mysqli_query($conn, "UPDATE users 
            SET name='$name', email='$email' 
            WHERE id='$user_id'");
    }

    $_SESSION['username'] = $name;

    echo "<script>alert('Profile Updated Successfully'); window.location='profile.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="container mt-5">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">📚 BookSwap</a>

    <div class="d-flex">
      <a href="dashboard.php" class="btn btn-outline-light btn-sm me-2">Home</a>
      <a href="profile.php" class="btn btn-outline-light btn-sm me-2">Profile</a>
      <a href="auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>
<h2>Edit Profile</h2>

<form method="POST" enctype="multipart/form-data" class="card p-4">

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Profile Picture</label>
        <input type="file" name="profile_pic" class="form-control">
    </div>

    <button type="submit" name="update" class="btn btn-primary">
        Update Profile
    </button>

</form>
<script src="assets/js/script.js"></script>
</body>
</html>