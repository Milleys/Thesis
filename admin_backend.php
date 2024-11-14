<?php
session_start();
$_SESSION["Username"];
$_SESSION["Email"];

include "backend/db_connect.php";


if (!isset($_SESSION['Username']) || empty($_SESSION['Username'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit(); // Exit to ensure no further code is executed after the redirect
}


$message = ''; // Initialize an empty message variable

if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];

    // SQL to delete a record
    $sql = "DELETE FROM account WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        $new_message = "Deleted User ID ".$delete_id."";
        $user = $_SESSION['Username'];
        $email = $_SESSION['Email'];
        $sql2 = "INSERT INTO history (Action_User, Action_Email, Action) VALUES ('$user','$email','$new_message')";
        $conn->query($sql2);

        $message = 'Record deleted successfully';
    } else {
        $message = 'Error deleting record';
    }


}

// Echo the JavaScript code to display the message in the modal if there's a message to show
if ($message) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                // Set the message in the modal body
                document.getElementById('feedbackMessage').textContent = '$message';
                // Show the feedback modal
                var feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
                feedbackModal.show();
            });
          </script>";
}

if (isset($_POST['save_changes'])) {
    $edit_id = $_POST['edit_id'];
    $edit_username = $_POST['edit_username'];
    $edit_email = $_POST['edit_email'];

    // SQL to update the record
    $sql = "UPDATE account SET username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $edit_username, $edit_email, $edit_id);
    
    if ($stmt->execute()) {

        $new_message = "Edited User ID ".$edit_id."";
        $user = $_SESSION['Username'];
        $email = $_SESSION['Email'];
        $sql2 = "INSERT INTO history (Action_User, Action_Email, Action) VALUES ('$user','$email','$new_message')";
        $conn->query($sql2);

        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('feedbackMessage').textContent = 'Record updated successfully';
                    var feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
                    feedbackModal.show();
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('feedbackMessage').textContent = 'Error updating record';
                    var feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
                    feedbackModal.show();
                });
              </script>";
    }
}

?>