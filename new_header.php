<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Header</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/header.css">
</head>

<body>
    <header class="py-2" style = "background-color: white;">
        <nav class="navbar navbar-expand-lg" >
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <?php
                include "backend/db_connect.php";

                @$username =  $_SESSION["Username"];
                @$email =  $_SESSION["Email"];

                $sql = "SELECT * FROM account WHERE username = ? AND email = ?";

                // Prepare the statement
                $stmt = $conn->prepare($sql);

                // Bind the parameters to prevent SQL injection
                $stmt->bind_param("ss", $username, $email);

                // Execute the statement
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $usertype = $row['Acc_Type'];
                    }
                } else {
                    // No user found
                }

                if (@$usertype == "admin") {
                ?>

                <!-- Navigation Links for Admin -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto ">
                        <li class="nav-item ">
                            <a class="nav-link text-black fw-4 fs-6 active"  href="#">GOVPH</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-black px-4 active"  href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black  px-4"  href="status.php">Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black  px-4" href="repositories.php">Repositories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black px-4" href="report.php">Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black  px-4" href="admin.php">Accounts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black  px-4" href="user_history.php">History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger px-4" data-bs-toggle="modal" data-bs-target="#logoutModal" style="cursor: pointer;" onmouseover="this.style.color='red'" onmouseout="this.style.color=''" >Logout</a>

                        </li>
                    </ul>
                </div>

                <?php
                } else if (@$usertype != "admin") {
                ?>

                <!-- Navigation Links for Non-admin -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto ">
                        <li class="nav-item ">
                            <a class="nav-link text-black px-4 active" style="border-left: .1px solid rgb(241, 241, 241);" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black  px-4"  href="status.php">Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black  px-4" href="repositories.php">Repositories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black px-4" href="report.php">Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger  px-4" data-bs-toggle="modal" data-bs-target="#logoutModal" style="cursor: pointer;">Logout</a>
                        </li>
                    </ul>
                </div>

                <?php } ?>
            </div> 
        </nav>
        <div class="container-fluid py-5 d-flex justify-content-center align-items-center" style="background-color: #BFD28E;">
            <img src="assets/llda-logo-21.png" alt="LLDA Logo" class="header-logo mx-3">
            <img src="assets/updated-logo-v-5-no-bilog-10.png" alt="Text Logo" class="header-logo-center mx-3">
            <img src="assets/bagong-pinas-10.png" alt="PH Logo" class="header-logo mx-3">
        </div>



    </header>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <!-- Cancel button -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <!-- Logout button -->
                    <form action="logout.php" method="POST">
                        <button type="submit" class="btn btn-danger" id="logoutBtn" name="logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>