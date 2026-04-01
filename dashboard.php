<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include 'config/db.php';

$user_id = $_SESSION['user_id'];

/* 🔴 COUNT PENDING REQUESTS */
$pending_requests = $conn->query("
    SELECT COUNT(*) AS total 
    FROM requests 
    WHERE owner_id='$user_id' AND status='Pending'
")->fetch_assoc()['total'];
$reviews = $conn->query("
    SELECT testimonials.*, users.name 
    FROM testimonials
    JOIN users ON testimonials.user_id = users.id
    ORDER BY testimonials.created_at DESC
    LIMIT 6
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-3">
    
    <!-- Logo / Title -->
    <a class="navbar-brand fw-bold bookswap-title" href="#">
        📚 BookSwap
    </a>

    <!-- Right Side -->
    <div class="ms-auto d-flex align-items-center gap-3">
        <a href="profile.php" class="nav-link text-dark fw-semibold">Profile</a>
        
        <a href="auth/logout.php" class="btn btn-dark px-3 py-2 rounded-pill">
            Logout
        </a>
    </div>

</nav>

<!-- DASHBOARD -->
<div class="container mt-4">

    <h2 class="welcome-text">Welcome <?php echo $_SESSION['username']; ?> 👋</h2>

    <div class="row g-4 mt-3">

        <!-- ADD BOOK -->
        <div class="col-md-3">
            <a href="books/add_book.php" class="card-link">
                <div class="feature-card">
                    <div class="icon">📘</div>
                    <img src="assets/images/add.jpg" class="step-img">
                    <h4 class="mt-3">Add Book</h4>
                    <p>List a book you want to share with others.</p>
                </div>
            </a>
        </div>

        <!-- VIEW BOOKS -->
        <div class="col-md-3">
            <a href="books/view_books.php" class="card-link">
                <div class="feature-card">
                    <div class="icon">📚</div>
                    <img src="assets/images/view.jpg" class="step-img">
                    <h4 class="mt-3">View Books</h4>
                    <p>Browse available books from other users.</p>
                </div>
            </a>
        </div>

        <!-- MY REQUESTS -->
        <div class="col-md-3">
            <a href="books/my_requests.php" class="card-link">
                <div class="feature-card">
                    <div class="icon">📤</div>
                    <img src="assets/images/request.jpg" class="step-img">
                    <h4 class="mt-3">My Requests</h4>
                    <p>Track the books you have requested.</p>
                </div>
            </a>
        </div>

        <!-- REQUESTS RECEIVED -->
        <div class="col-md-3">
            <a href="books/view_requests.php" class="card-link">
                <div class="feature-card position-relative">

                    <div class="icon">📥</div>

                    <!-- 🔴 NOTIFICATION BADGE -->
                    <?php if($pending_requests > 0){ ?>
                        <span class="notify-badge">
                            <?php echo $pending_requests; ?>
                        </span>
                    <?php } ?>

                    <img src="assets/images/received.jpg" class="step-img">
                    <h4 class="mt-3">Requests Received</h4>
                     <p>Manage requests from other users.</p>

                </div>
            </a>
        </div>
        <!-- WHY USERS LOVE -->
<div class="mt-5">

    <h4 class="text-center mb-4">Why Users Love BookSwap</h4>

    <div class="row g-3">

        <div class="col-md-6">
            <div class="love-box">✔ Save money on books you want to read</div>
        </div>

        <div class="col-md-6">
            <div class="love-box">✔ Reduce waste by giving books a second life</div>
        </div>

        <div class="col-md-6">
            <div class="love-box">✔ Connect with a community of book lovers</div>
        </div>

        <div class="col-md-6">
            <div class="love-box">✔ Discover new books and authors</div>
        </div>

        <div class="col-md-6">
            <div class="love-box">✔ Free up space in your home</div>
        </div>

        <div class="col-md-6">
            <div class="love-box">✔ Support sustainable reading habits</div>
        </div>

    </div>

</div>
<!-- TESTIMONIALS -->
<div class="mt-5">

    <p class="text-center text-success">Testimonials</p>
    <h2 class="text-center mb-4">What Our Users Say</h2>

    <div class="text-end mb-3">
        <a href="reviews/add_testimonial.php" class="btn btn-dark btn-sm">+ Add Review</a>
    </div>

    <div class="row g-4">

        <?php while($row = $reviews->fetch_assoc()) { ?>
            
            <div class="col-md-4">
                <div class="review-card">
                    <p>"<?php echo $row['message']; ?>"</p>
                    <h6>- <?php echo $row['name']; ?></h6>
                </div>
            </div>

        <?php } ?>

    </div>

</div>

    </div>

</div>
<?php include 'footer.php'; ?>
</body>
</html>