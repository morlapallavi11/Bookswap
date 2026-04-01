
<?php
session_start();
include '../config/db.php';

// Get search and genre filter values
$search = trim($_GET['search'] ?? '');
$genre = $_GET['genre'] ?? '';

$conditions = [];

// Search condition
if ($search != "") {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $conditions[] = "(books.title LIKE '%$search_safe%' OR books.author LIKE '%$search_safe%')";
}

// Genre filter
if ($genre != "") {
    $genre_safe = mysqli_real_escape_string($conn, $genre);
    $conditions[] = "LOWER(books.genre) = LOWER('$genre_safe')";
}

// Base query
$sql = "SELECT books.*, users.name AS owner_name, users.email 
        FROM books 
        JOIN users ON books.user_id = users.id";

// Apply filters if any
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Order by latest first
$sql .= " ORDER BY books.created_at DESC";

$result = $conn->query($sql);
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f8; }
        .card { background-color: #ffffff; box-shadow: 0 3px 8px rgba(0,0,0,0.15); }
        .bookswap-title { font-weight: bold; font-size: 1.5rem; color: #fff; }
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

<div class="container mt-4">
<h2 class="mb-4">Available Books</h2>

<!-- Search & Filter -->
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="search" class="form-control search-bar"
               placeholder="Search books..." value="<?php echo htmlspecialchars($search); ?>">
    </div>
    <div class="col-md-3">
        <select name="genre" class="form-select">
            <option value="">All Genres</option>
            <option value="Fiction" <?php if($genre=='Fiction') echo 'selected'; ?>>Fiction</option>
            <option value="self-help" <?php if($genre=='self-help') echo 'selected'; ?>>self-help</self-help></option>
            <option value="Mystery" <?php if($genre=='Mystery') echo 'selected'; ?>>Mystery</option>
            <option value="Sociology" <?php if($genre=='Sociology') echo 'selected'; ?>>Sociology</option>
            <option value="Mystery" <?php if($genre=='Mystery') echo 'selected'; ?>>Mystery</option>
            <option value="Thriller" <?php if($genre=='Thriller') echo 'selected'; ?>>Thriller</option>
        </select>
        </select>
        </select>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Search</button>
    </div>
    <div class="col-md-2">
        <a href="view_books.php" class="btn btn-secondary w-100">Clear</a>
    </div>
</form>

<!-- Book Cards -->
<div class="row">
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="../uploads/<?php echo $row['image']; ?>" class="card-img-top" style="height:250px; object-fit:cover;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                <p><strong>Author:</strong> <?php echo $row['author']; ?></p>
                <p><strong>Genre:</strong> <?php echo $row['genre']; ?></p>
                <p><strong>Condition:</strong> <?php echo $row['book_condition']; ?></p>
                <p><strong>Owner:</strong> <?php echo $row['owner_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                <p><?php echo $row['description']; ?></p>

                <a href="request_book.php?book_id=<?php echo $row['id']; ?>&owner_id=<?php echo $row['user_id']; ?>"
                   class="btn btn-primary">Request</a>
            </div>
        </div>
    </div>
<?php
    }
} else {
    echo "<p class='text-center'>No books found 😢</p>";
}
?>
</div>

</div>
</body>
</html>