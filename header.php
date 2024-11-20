<header class="py-3" style="background-color: #BFD28E;">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo Section with Title and Tagline -->
        <div class="d-flex justify-content-center align-items-center flex-grow-1">
            <img src="assets/llda-logo-21.png" alt="LLDA Logo" class="header-logo me-3">
            <div>
                <img src="assets/updated-logo-v-5-no-bilog-10.png" alt="Text Logo" class="header-logo-center me-0">
            </div>
            <img src="assets/bagong-pinas-10.png" alt="PH Logo" class="header-logo me-3">
        </div>

        <!-- Navigation Links Section -->
        <nav id="nav-links" class="d-flex align-items-center"></nav>

        <!-- Button Section (default button) -->
        <div class="d-flex align-items-center">
            <a href="#" id="dynamic-button" class="btn btn-success">Default Button</a>
        </div>
    </div>


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
</header>



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
}else{
  
}

if(@$usertype == "admin"){
?>
<script>
    // Get the current page from the URL path
    const currentPage = window.location.pathname;

    // Function to set active page styles or adjust href based on the page
    function adjustHeaderForActivePage() {
        const registerLink = document.getElementById('register-link');
        const navLinks = document.getElementById('nav-links'); // Targeting nav-links div
        const dynamicButton = document.getElementById('dynamic-button');

        // If the current page is "home.php", add navigation links
        if (currentPage.includes("home.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link">Report</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="admin.php" class="nav-link">Accounts</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="user_history.php" class="nav-link">History</a>
                    </li>
                    
                </ul>
            `;
        }
        else if (currentPage.includes("status.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link active">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link">Report</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="admin.php" class="nav-link">Accounts</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="user_history.php" class="nav-link">History</a>
                    </li>
                    
                </ul>
            `;
        }
        else if (currentPage.includes("repositories.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link active">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link">Report</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="admin.php" class="nav-link">Accounts</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="user_history.php" class="nav-link">History</a>
                    </li>
                </ul>
            `;
        }
        else if (currentPage.includes("report.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link active">Report</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="admin.php" class="nav-link">Accounts</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="user_history.php" class="nav-link">History</a>
                    </li>
                </ul>
            `;
        }
        else if (currentPage.includes("admin.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link">Report</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="admin.php" class="nav-link active">Accounts</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="user_history.php" class="nav-link">History</a>
                    </li>
                </ul>
            `;
        }
        else if (currentPage.includes("user_history.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link">Report</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="admin.php" class="nav-link">Accounts</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="user_history.php" class="nav-link active">History</a>
                    </li>
                </ul>
            `;
        }

        // Example: If the current page is "login.php", update the button
        if (currentPage.includes("login.php")) {
            dynamicButton.textContent = 'Register Here';
            dynamicButton.href = 'register.php';
            dynamicButton.removeAttribute('data-bs-toggle');
            dynamicButton.removeAttribute('data-bs-target');
        }
        else if (currentPage.includes("register.php")) {
            dynamicButton.textContent = 'Login Here';
            dynamicButton.href = 'login.php';
            dynamicButton.removeAttribute('data-bs-toggle');
            dynamicButton.removeAttribute('data-bs-target');
        }
        else {
            // Set Logout button for main pages
            dynamicButton.textContent = 'Logout';
            dynamicButton.href = 'login.php';  // Prevent default navigation
            dynamicButton.setAttribute('data-bs-toggle', 'modal');
            dynamicButton.setAttribute('data-bs-target', '#logoutModal')
        }
    }

    // Call the function to adjust the header based on the active page
    adjustHeaderForActivePage();
</script>
<?php
}else if(@$usertype != "admin"){
?>
<script>
    // Get the current page from the URL path
    const currentPage = window.location.pathname;

    // Function to set active page styles or adjust href based on the page
    function adjustHeaderForActivePage() {
        const registerLink = document.getElementById('register-link');
        const navLinks = document.getElementById('nav-links'); // Targeting nav-links div
        const dynamicButton = document.getElementById('dynamic-button');

        // If the current page is "home.php", add navigation links
        if (currentPage.includes("home.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link">Report</a>
                    </li>
                </ul>
            `;
        }
        else if (currentPage.includes("status.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link active">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link">Report</a>
                    </li>
                </ul>
            `;
        }
        else if (currentPage.includes("repositories.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link active">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link">Report</a>
                    </li>
                </ul>
            `;
        }
        else if (currentPage.includes("report.php")) {
            navLinks.innerHTML = `
                <ul class="d-flex list-unstyled mb-0">
                    <li class="nav-item me-3">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="status.php" class="nav-link">Status</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="repositories.php" class="nav-link">Repositories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="report.php" class="nav-link active">Report</a>
                    </li>
                </ul>
            `;
        }
        // Example: If the current page is "login.php", update the button
        if (currentPage.includes("login.php")) {
            dynamicButton.textContent = 'Register Here';
            dynamicButton.href = 'register.php';
            dynamicButton.removeAttribute('data-bs-toggle');
            dynamicButton.removeAttribute('data-bs-target');
        }
        else if (currentPage.includes("register.php")) {
            dynamicButton.textContent = 'Login Here';
            dynamicButton.href = 'login.php';
            dynamicButton.removeAttribute('data-bs-toggle');
            dynamicButton.removeAttribute('data-bs-target');
        }
        else {
            // Set Logout button for main pages
            dynamicButton.textContent = 'Logout';
            dynamicButton.href = 'login.php';  // Prevent default navigation
            dynamicButton.setAttribute('data-bs-toggle', 'modal');
            dynamicButton.setAttribute('data-bs-target', '#logoutModal')
        }
    }

    // Call the function to adjust the header based on the active page
    adjustHeaderForActivePage();
</script>

<?php
        }

?>


<script type="text/javascript">
    document.getElementById('logoutBtn').onclick = function() {
        window.location.href = 'login.php';
    };
</script>

