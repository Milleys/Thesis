<?php


session_start();
include 'backend/db_connect.php';
$_SESSION["Username"];
$_SESSION["Email"];


//test

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
    <title>Home</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap css link -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Css Paths -->
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/home.css">
    
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body>

    <!-- HEADER nav bar start -->
    <?php include 'header.php'; ?>
    <!-- HEADER nav bar end -->

    <!-- main content start -->
    <main>
        <!-- Loading Screen -->
        <div id="loading-screen">
        <!-- Lottie animation player -->
        <dotlottie-player src="https://lottie.host/d283b94d-6898-4495-9883-cdc6ada3e7b5/79Vf6zVZPx.json"
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
        </dotlottie-player>
        </div>

        <div class="row justify-content-center">
            <!-- Title Section -->
            <div class="col-12 text-center mb-4">
                <h3><a href="report.php">View Quarterly Report</a></h3>
            </div>

            <!-- Image and Legend Section -->
            <div class="col-lg-8 d-flex justify-content-center align-items-start">
                <!-- Report Image Section -->
                <div class="col-md-10 text-center">
                    <div class="report-image mb-8">
                        <img src="assets/Laguna Lake from LLDA 1.png" alt="Quarterly Report" class="img-fluid">
                    </div>
                </div>

                <!-- Legend Section -->
                <div class="col-md-4 ms-3">
                    <div class="legend bg-light p-3 rounded">
                        <h5>Legend</h5>
                        <ul class="list-unstyled">
                            <li><span style="color: green;">●</span> Laguna Lake Stations</li>
                            <li><span style="color: red;">●</span> Tributary Rivers Stations</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- main content end -->

    <!-- FOOTER Section Start -->
    <?php include 'footer.php'; ?>
    <!-- FOOTER Section End -->

    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/loadingscreen.js"></script>
</body>

</html>
