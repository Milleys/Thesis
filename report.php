<?php
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
    <title>Home</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap css link -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Css Paths -->
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/report.css">

    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>

<body>

    <!-- HEADER nav bar start -->
    <?php include 'header.php'; ?>
    <!-- HEADER nav bar end -->



    <!-- Main content start -->
    <main class="">
         <!-- Loading Screen -->
        <div id="loading-screen">
        <!-- Lottie animation player -->
        <dotlottie-player src="https://lottie.host/d283b94d-6898-4495-9883-cdc6ada3e7b5/79Vf6zVZPx.json"
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
        </dotlottie-player>
        </div>

        <div class="row justify-content-center w-100">
            <!-- Uploaded PDF Reports Section -->
            <div class="col-md-4">
                <div class="uploaded-pdf-section bg-light p-3 rounded shadow-sm text-center">
                    <h5 class="text-success">Uploaded PDF Reports</h5>
                    <form id="pdfForm" method="POST" action="backend/del_pdf.php">
                        <ul class="list-unstyled">
                            <?php
                            // Connect to the database to fetch the list of PDFs
                            include 'backend/db_connect.php';

                            // Query to get the list of uploaded PDF files
                            $sql = "SELECT id, filename, filepath FROM pdf_files";
                            $result = $conn->query($sql);

                            // Display each PDF as a link with a checkbox for deletion
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li>
                    <input type='checkbox' name='pdf_ids[]' value='" . $row['id'] . "'>
                    <a href='#' onclick=\"loadPDF('" . $row['filepath'] . "')\">" . htmlspecialchars($row['filename']) . "</a>
                  </li>";
                                }
                            } else {
                                echo "<li>No PDFs uploaded yet.</li>";
                            }

                            // Close the database connection
                            $conn->close();
                            ?>
                        </ul>
                    </form>
                    <!-- Delete Button -->
                    <button class="btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Selected</button>
                </div>
            </div>

            <!-- Findings Section -->
            <div class="col-md-8">
                <div class="findings-section bg-light p-3 rounded shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-success">Findings</h5>
                        <div class="upload-section d-flex align-items-center">
                            <form action="backend/upload_pdf.php" method="post" enctype="multipart/form-data">
                                <input type="file" class="form-control me-2" style="max-width: 250px;" id="fileToUpload" name="fileToUpload">
                                <button class="btn btn-success" value="Upload PDF" name="submit">Upload PDF</button>
                            </form>
                        </div>
                    </div>
                    <div class="findings-content bg-light p-4 rounded border">
                        <!-- Placeholder for PDF content or findings -->
                        <iframe id="pdfViewer" src="" width="100%" height="400px" style="border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Main content end -->


    <!-- FOOTER Section Start -->
    <?php include 'footer.php'; ?>
    <!-- FOOTER Section End -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected files? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                </div>
            </div>
        </div>

        <!-- JavaScript for delete confirmation -->
        <script>
            function confirmDelete() {
                // Close the modal
                let modalElement = document.getElementById('deleteModal');
                let modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();

                // Submit the form after confirming
                document.getElementById('pdfForm').submit();
            }
        </script>
        <!-- Bootstrap JS -->
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="script/loadingscreen.js"></script>
        <script>
            // Function to load PDF into iframe
            function loadPDF(filePath) {
                var pdfViewer = document.getElementById('pdfViewer');
                pdfViewer.src = "backend/" + filePath;
            }
        </script>
</body>

</html>