
<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT requests.*, books.title, users.name AS requester_name, users.email
        FROM requests
        JOIN books ON requests.book_id = books.id
        JOIN users ON requests.requester_id = users.id
        WHERE requests.owner_id = '$user_id'
        ORDER BY requests.created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f8; }
        .bookswap-title { font-weight: bold; font-size: 1.5rem; color: #fff; }
        .card { background-color: #fff; box-shadow: 0 3px 8px rgba(0,0,0,0.15); padding: 20px; border-radius: 8px; margin-top: 30px; }
        table th, table td { vertical-align: middle !important; }
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
    <h2 class="mb-4 text-center">Book Requests Received</h2>

    <div class="card">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Requester</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result->num_rows > 0) { ?>
                    <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($row['requester_name']); ?>
                                <?php if ($row['status'] == 'Approved' || $row['status'] == 'accepted') { ?>
                                    <br>
                                    <small><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></small>
                                <?php } ?>
                            </td>
                            <td>
                                <?php 
                                if ($row['status'] == 'Pending') echo "<span class='text-warning'>Pending</span>";
                                elseif ($row['status'] == 'Approved' || $row['status'] == 'accepted') echo "<span class='text-success'>Approved</span>";
                                else echo "<span class='text-danger'>Rejected</span>";
                                ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <a href="update_request.php?id=<?php echo $row['id']; ?>&action=approve" 
                                       class="btn btn-success btn-sm">Approve</a>
                                    <a href="update_request.php?id=<?php echo $row['id']; ?>&action=reject" 
                                       class="btn btn-danger btn-sm">Reject</a>
                                <?php } elseif ($row['status'] == 'Approved' || $row['status'] == 'accepted') { ?>
                                    <a href="../chat/chat.php?user_id=<?php echo $row['requester_id']; ?>&book_id=<?php echo $row['book_id']; ?>" 
                                       class="btn btn-primary btn-sm">💬 Chat</a>
                                <?php } else { ?>
                                    <span class="text-danger">Rejected</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">No book requests received 😢</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>