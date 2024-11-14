<?php
include 'backend/db_connect.php';

// handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // validate form fields
    if (empty($username) || empty($password)) {
    } else {
        // check user credentials
        $sql = "SELECT * FROM account WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Echo passwords for debugging
            //echo "Entered Password: " . $password . "<br>";
            //echo "Hashed Password from DB: " . $row['password'] . "<br>";
            // Debug: check length and content
            //echo "Length of Entered Password: " . strlen($password) . "<br>";
            //echo "Length of Hashed Password: " . strlen($row['password']) . "<br>";

            //echo $password;
            //echo $row['password'];
            if (password_verify($password, $row['password'])) {
                //Login
               
                $_SESSION["Username"] = $username;
                $_SESSION["Email"] =  $row['email'];

                
                echo '<meta http-equiv="refresh" content="0;url=home.php">';




                exit();
            } else {
                echo "
                <script>
                alert('incorrect password');
                </script>
                ";
            }
        } else {
            echo "
            <script>
            alert('No user found with that username.');
            </script>
            ";
        }
    }
}

$conn->close();

?>


