<?php
include '../config/db.php';
if(!isset($book_id)){
    $book_id=0;
}
//$book_id = $_GET['book_id'];

$sql = "SELECT reviews.*, users.name 
        FROM reviews 
        JOIN users ON reviews.user_id = users.id
        WHERE reviews.book_id = '$book_id'
        ORDER BY reviews.created_at DESC";
$sql_avg = "SELECT AVG(rating) as avg_rating FROM reviews WHERE book_id='$book_id'";
$res_avg = mysqli_query($conn, $sql_avg);
$data = mysqli_fetch_assoc($res_avg);

// FIX: check before using
$avg = isset($data['avg_rating']) ? round($data['avg_rating'],1) : 0;

echo "<p><strong>Average Rating:</strong> $avg ⭐</p>";


$result = mysqli_query($conn, $sql);

echo "<h3>All Reviews</h3>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
    echo "<strong>" . $row['name'] . "</strong><br>";
    echo "Rating: " . $row['rating'] . " ⭐<br>";
    echo "<p>" . $row['review_text'] . "</p>";
    echo "</div>";
}
?>