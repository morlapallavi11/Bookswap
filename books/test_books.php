<?php
include '../config/db.php';

// SQL to fetch all books
$sql = "SELECT books.*, users.name AS owner_name 
        FROM books 
        JOIN users ON books.user_id = users.id 
        ORDER BY books.created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}

echo "Total books: " . $result->num_rows . "<br><br>";

while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Title: " . $row['title'] . " | Owner: " . $row['owner_name'] . "<br>";
}
?>