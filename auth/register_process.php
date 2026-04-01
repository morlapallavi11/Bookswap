
<?php

include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // HASH PASSWORD (VERY IMPORTANT)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        echo "Email already registered!";
    } else {

        $sql = "INSERT INTO users (name, email, password)
                VALUES ('$name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration Successful! <br>";
            echo "<a href='login.php'>Click here to Login</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

