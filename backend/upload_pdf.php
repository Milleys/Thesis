<?php
include 'db_connect.php';
session_start();
$_SESSION["Username"];
$_SESSION["Email"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";

    // Ensure the upload directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Check for file upload errors
    if ($_FILES['fileToUpload']['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../report.php");
        exit();
    }

    // Sanitize the filename
    $filename = basename($_FILES["fileToUpload"]["name"]);
    $filename = preg_replace("/[^A-Za-z0-9_\-\.]/", '_', $filename);
    $target_file = $target_dir . $filename;

    // Check if file is a PDF
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($fileType != "pdf") {
        header("Location: ../report.php");
        exit();
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        header("Location: ../report.php");
        exit();
    }

    // Attempt to move the uploaded file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // Insert file info into the database
        $sql = "INSERT INTO pdf_files (filename, filepath) VALUES ('$filename', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            header("Location: ../report.php");
            $message = "Uploaded ".$filename."";
            $user = $_SESSION['Username'];
            $email = $_SESSION['Email'];
            $sql2 = "INSERT INTO history (Action_User, Action_Email, Action) VALUES ('$user','$email','$message')";
            $conn->query($sql2);
        } else {
            header("Location: ../report.php");
        }
    } else {
        header("Location: ../report.php");
    }
}

$conn->close();
