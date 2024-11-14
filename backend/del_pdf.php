<?php
session_start();
$_SESSION["Username"];
$_SESSION["Email"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['pdf_ids'])) {
    $pdf_ids = $_POST['pdf_ids'];

    // Debugging output
    // print_r($pdf_ids); // Uncomment this line to see what PDF IDs are being sent

    include 'db_connect.php';

    // Prepare statement to fetch the file path of each selected PDF before deletion
    $stmt = $conn->prepare("SELECT filepath FROM pdf_files WHERE id = ?");
    
    // Loop through each selected PDF ID
    foreach ($pdf_ids as $id) {
        // Bind parameter and execute query to get the file path
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($filepath);
        $stmt->fetch();
        
        // Delete the file from the file system
        if (file_exists($filepath)) {
            unlink($filepath);  // Deletes the file
        }

        // Close the result binding
        $stmt->free_result();

        // Now delete the record from the database
        $delete_stmt = $conn->prepare("DELETE FROM pdf_files WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        $delete_stmt->execute();
        $delete_stmt->close();
        


        $message = "deleted PDF ID #".$id." ";
        $user = $_SESSION['Username'];
        $email = $_SESSION['Email'];
        $sql2 = "INSERT INTO history (Action_User, Action_Email, Action) VALUES ('$user','$email','$message')";
        $conn->query($sql2);
        // Redirect back to the page or show success message
        header("Location: ../report.php");
    }

 



    exit();
} else {
    echo "No PDFs selected for deletion.";
}
?>
