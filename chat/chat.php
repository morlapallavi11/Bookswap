<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    echo "Login required";
    exit();
}

$sender_id = $_SESSION['user_id'];
$receiver_id = $_GET['user_id'];
$book_id = $_GET['book_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial;
        }

        #chat-box {
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            background: #f5f5f5;
        }

        .message {
            display: flex;
            margin-bottom: 10px;
        }

        .me {
            justify-content: flex-end;
        }

        .other {
            justify-content: flex-start;
        }

        .msg {
            padding: 10px;
            border-radius: 10px;
            max-width: 60%;
        }

        .me .msg {
            background: #007bff;
            color: white;
        }

        .other .msg {
            background: #e4e6eb;
        }

        .profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 8px;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../dashboard.php">📚 BookSwap</a>

    <div class="d-flex">
      <a href="../dashboard.php" class="btn btn-outline-light btn-sm me-2">Home</a>
      <a href="../profile.php" class="btn btn-outline-light btn-sm me-2">Profile</a>
      <a href="../auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>
<h2>💬 Chat</h2>

<div id="chat-box"></div>

<form id="chat-form">
    <input type="text" id="message" placeholder="Type message..." required style="width:70%;">
    <button type="submit">Send</button>
</form>

<script>
function loadMessages(){
    fetch("fetch_messages.php?receiver_id=<?php echo $receiver_id; ?>&book_id=<?php echo $book_id; ?>")
    .then(res => res.text())
    .then(data => {
        document.getElementById("chat-box").innerHTML = data;

        // auto scroll
        let chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
    });
}

document.getElementById("chat-form").addEventListener("submit", function(e){
    e.preventDefault();

    let message = document.getElementById("message").value;

    fetch("send_message.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "message=" + message + "&receiver_id=<?php echo $receiver_id; ?>&book_id=<?php echo $book_id; ?>"
    }).then(() => {
        document.getElementById("message").value = "";
        loadMessages();
    });
});

setInterval(loadMessages, 1000);
loadMessages();
</script>
<script src="../assets/js/script.js"></script>
</body>
</html>