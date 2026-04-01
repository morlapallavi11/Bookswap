<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<h3>Add Review</h3>

<form action="/bookswap/reviews/add_review.php" method="POST">
    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">

    <label>Rating:</label>
    <select name="rating" required>
        <option value="">Select</option>
        <option value="1">1 ⭐</option>
        <option value="2">2 ⭐⭐</option>
        <option value="3">3 ⭐⭐⭐</option>
        <option value="4">4 ⭐⭐⭐⭐</option>
        <option value="5">5 ⭐⭐⭐⭐⭐</option>
    </select>

    <br><br>

    <textarea name="review_text" placeholder="Write your review..." required></textarea>

    <br><br>

    <button type="submit">Submit</button>
</form>