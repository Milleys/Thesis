<?php 
include "backend/db_connect.php";
session_start();
$_SESSION["Username"];
$_SESSION["Email"];
if (!isset($_SESSION['Username']) || empty($_SESSION['Username'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit(); // Exit to ensure no further code is executed after the redirect
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Account Management</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/global.css">

    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    <style>
        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
            padding: 20px;
        }

        .table-container {
            max-width: 1000px;
            /* Maximum width for the container */
            width: 100%;
            margin: 0 auto;
            /* Center the table container */
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* Hide overflow to maintain a clean border */
        }

        .table-scrollable {
            max-height: 400px;
            /* Set max height for scrollable area */
            overflow-y: auto;
            /* Enable vertical scrolling */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #f8f9fa;
            z-index: 2;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
        }

        th,
        td {
            text-align: center;
            padding: 10px;
        }

    </style>
</head>

<body>

    <!-- HEADER nav bar start -->
    <?php include 'new_header.php'; ?>
    <!-- HEADER nav bar end -->

    <!-- Main content start -->
    <main class="main-container">

        <!-- Loading Screen -->
        <div id="loading-screen">
        <!-- Lottie animation player -->
        <dotlottie-player src="https://lottie.host/d283b94d-6898-4495-9883-cdc6ada3e7b5/79Vf6zVZPx.json"
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
        </dotlottie-player>
        </div>

        <h2 class="mb-4" style="color: #1B7019;">User History</h2>
        <div class="table-container">
            <!-- Single table with scrollable body -->
            <div class="table-scrollable">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $sql = "SELECT * FROM history";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['Action_ID']; ?></td>
                            <td><?php echo $row['Action_User']; ?></td>
                            <td><?php echo $row['Action_Email']; ?></td>
                            <td><?php echo $row['Action']; ?></td>
                            <td><?php echo $row['TimeStamp']; ?></td>
                        </tr>

                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>No records found.</td></tr>";
                        }

                        
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- Main content end -->

    <!-- FOOTER Section Start -->
    <?php include 'footer.php'; ?>
    <!-- FOOTER Section End -->

    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/loadingscreen.js"></script>
</body>

</html>