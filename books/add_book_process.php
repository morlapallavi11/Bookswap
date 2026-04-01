
<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$description = $_POST['description'];
$condition = $_POST['book_condition'];

// Image Upload
$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

$upload_path = "../uploads/" . $image;

// Move file to uploads folder
move_uploaded_file($tmp, $upload_path);

// Insert into DB
$sql = "INSERT INTO books (user_id, title, author, genre, description, book_condition, image)
        VALUES ('$user_id', '$title', '$author', '$genre', '$description', '$condition', '$image')";

if ($conn->query($sql) === TRUE) {
    echo "Book Added Successfully! <br><a href='add_book.php'>Add Another Book</a>";
} else {
    echo "Error: " . $conn->error;
}
?>