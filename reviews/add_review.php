<?php
session_start();
include '../config/db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// STEP 1: Check request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // STEP 2: Validate inputs
    if (!isset($_POST['book_id'], $_POST['rating'], $_POST['review_text'])) {
        die("Form data missing!");
    }

    // STEP 3: Get values
    $book_id = $_POST['book_id'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $user_id = $_SESSION['user_id'];

    // STEP 4: Check if book exists (IMPORTANT)
    $check = mysqli_query($conn, "SELECT id FROM books WHERE id='$book_id'");
    if (mysqli_num_rows($check) == 0) {
        die("Invalid book ID!");
    }

    // STEP 5: Insert review
    $sql = "INSERT INTO reviews (book_id, user_id, rating, review_text)
            VALUES ('$book_id', '$user_id', '$rating', '$review_text')";

    if (!mysqli_query($conn, $sql)) {
        die("MySQL Error: " . mysqli_error($conn));
    }

    // STEP 6: Redirect
    header("Location: ../books/view_books.php");
    exit();  // VERY IMPORTANT
}
?>