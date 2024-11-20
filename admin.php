<?php
include "backend/db_connect.php";
include "admin_backend.php";
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
    <link rel="stylesheet" href="styles/admin.css">

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

        .btn-edit {
            background-color: #1B7019;
            /* Custom green color for Edit button */
            color: white;
            border-color: #056839;
        }

        .btn-edit:hover {
            background-color: #218838;
            /* Darker shade on hover */
            color: white;
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

        <h2 class="mb-4" style="color: #1B7019;">Account Management</h2>
        <div class="table-container">
            <!-- Single table with scrollable body -->
            <div class="table-scrollable">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM account";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td> <?php echo $row['id']; ?></td>
                                    <td> <?php echo $row['username']; ?> </td>
                                    <td> <?php echo $row['email']; ?> </td>
                                    <td>
                                        <button type="button" class='btn btn-edit btn-sm' data-bs-toggle='modal' 
                                                data-bs-target='#editModal' 
                                                data-id="<?php echo $row['id']; ?>" 
                                                data-username="<?php echo $row['username']; ?>" 
                                                data-email="<?php echo $row['email']; ?>">
                                            Edit
                                        </button>
                                        <button type="button" class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id="<?php echo $row['id']; ?>">Delete</button>
                                    </td>


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
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" name="edit_id" id="edit_id"> <!-- Hidden input to hold the ID -->
                        <div class="mb-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="edit_username" id="edit_username">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="edit_email" id="edit_email">
                        </div>
                        <button type="submit" name="save_changes" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


        <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this account?</p>
                    <form method="POST" action="">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="feedbackMessage">
                    <!-- The message will be inserted here by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <!-- FOOTER Section Start -->
    <?php include 'footer.php'; ?>
    <!-- FOOTER Section End -->

    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/loadingscreen.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach an event listener to all buttons with the 'data-bs-target' attribute pointing to #deleteModal
            document.querySelectorAll('[data-bs-target="#deleteModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    // Get the ID from the button's data-id attribute
                    const userId = button.getAttribute('data-id');
                    // Set the ID in the hidden input field of the modal
                    document.getElementById('delete_id').value = userId;
                });
            });

            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    // Get data from the button attributes
                    const userId = button.getAttribute('data-id');
                    const username = button.getAttribute('data-username');
                    const email = button.getAttribute('data-email');

                    // Set data in the modal input fields
                    document.getElementById('edit_id').value = userId;
                    document.getElementById('edit_username').value = username;
                    document.getElementById('edit_email').value = email;
                });
            });
        });
    </script>

   



</body>

</html>