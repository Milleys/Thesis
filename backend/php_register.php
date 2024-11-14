<?php
include 'backend/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form fields (formalization)
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // HGash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $sql = "INSERT INTO account (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            // Successfully login
            $_SESSION["Username"] = $username;
            $_SESSION["Email"] =  $email;
            echo '<meta http-equiv="refresh" content="0;url=home.php">';
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
