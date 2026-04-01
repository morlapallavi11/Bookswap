<?php
session_start();
include '../config/db.php';

$my_id = $_SESSION['user_id'];
$other_id = $_GET['receiver_id'];
$book_id = $_GET['book_id'];

$sql = "SELECT messages.*, users.name, users.profile_pic 
        FROM messages
        JOIN users ON messages.sender_id = users.id
        WHERE ((sender_id='$my_id' AND receiver_id='$other_id') 
        OR (sender_id='$other_id' AND receiver_id='$my_id'))
        AND book_id='$book_id'
        ORDER BY messages.created_at ASC";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {

    $isMe = ($row['sender_id'] == $my_id);

    $img = !empty($row['profile_pic']) ? $row['profile_pic'] : "default.png";

    echo '<div class="message '.($isMe ? 'me' : 'other').'">';

    if(!$isMe){
        echo '<img src="../uploads/'.$img.'" class="profile">';
    }

    echo '<div class="msg">';
    echo $row['message'];
    echo '</div>';

    if($isMe){
        echo '<img src="../uploads/'.$img.'" class="profile">';
    }

    echo '</div>';
}
?>