<?php
#UPLOAD DATA SET
error_reporting(0);  // Disable all error reporting
ini_set('display_errors', 0);  // Do not display any errors
session_start();
include 'backend/db_connect.php';
$_SESSION["Username"];
$_SESSION["Email"];
// Set the target directory
$target_dir = 'C:/Users/' . getenv('USERNAME') . '/Desktop/Datamodel/';
$url = "repositories.php";
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the uploaded file information
    $file = $_FILES['dataset'];
    $file_name = basename($file['name']);
    $target_file = $target_dir . $file_name;
    
    // Validate if the file is a CSV
    $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

    // Check for errors in file upload
    if ($file['error'] === UPLOAD_ERR_OK) {
        
        // Server-side validation for CSV extension
        if (strtolower($file_type) != "csv") {
            echo "
                <script>
                alert('Sorry, only CSV files are allowed.');
                </script>
                ";
        } else {
            // Move the uploaded file to the specified folder if it's a CSV
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                echo "The file " . htmlspecialchars($file_name) . " has been uploaded successfully.";
                $message = "Uploaded New Dataset_".$file_name."";
                $user = $_SESSION['Username'];
                $email = $_SESSION['Email'];
                $sql2 = "INSERT INTO history (Action_User, Action_Email, Action) VALUES ('$user','$email','$message')";
                $conn->query($sql2);

                header('Location: '.$url);
            } else {
                echo "
                <script>
                alert('Sorry, there was an error uploading your file.');
                </script>
                ";
            }
        }
    } else {
        
    }
}



?>