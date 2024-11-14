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
    <link rel="stylesheet" href="styles/register.css">

    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>



<body>

    <!-- HEADER nav bar start -->
    <?php
    session_start();
    @$_SESSION["Username"];
    @$_SESSION["Email"];
    if (isset($_SESSION['Username']) || !empty($_SESSION['Username'])) {
        // Redirect to the login page
        header('Location: home.php');
        exit(); // Exit to ensure no further code is executed after the redirect
    }
    include 'header.php';
    include 'backend/php_register.php'
    ?>
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

        <div class="register-container">
            <h2>Register Here</h2>

            <!-- register Form -->
            <form action="register.php" method="post" id="registerForm">

                <!-- Username input with icon -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-at"></i> Email
                    </label>
                    <input type="text" class="form-control" id="username" name="email" placeholder="Enter email" required>
                </div>

                <!-- Username input with icon -->
                <div class="mb-3">
                    <label for="username" class="form-label">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                </div>

                <!-- Password input with icon -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required> 
                </div>

                <!-- Confirm Password input with icon -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Confirm Password
                    </label>
                    <input type="password" class="form-control" id="password" name="confirm_password" placeholder="Confirm password" required>
                </div>

                

                <!-- Submit button -->
                <button type="submit" class="btn btn-register w-100 mb-3">Register</button>
                <h5>Register Via:</h5>
                <!-- Google register submit button -->
                <div id="g_id_onload"
                    data-client_id="559225362339-dfnbc9trnkvn7hkm172gml9l6a9squ8i.apps.googleusercontent.com"
                    data-callback="handleCredentialResponse">
                </div>
                <div class="g_id_signin" data-type="standard" class="btn btn-outline-danger d-flex align-items-center"
                        style="border-radius: 50px; padding: 5px 78px;" ></div>
                <!--
                <div class="d-flex justify-content-center mb-3">
                    <button type="button" id="custom-google-signin" class="btn btn-outline-danger d-flex align-items-center"
                        style="border-radius: 50px; padding: 5px 10px;">
                        <img src="assets/google-10.png" alt="Google Icon" style="width: 20px;">
                        <span class="ms-2">Google</span>
                    </button>
                </div> -->


                <!-- Register link -->
                <div class="text-center mt-3">
                    <p>Already a user? <a href="register.php">register Here</a></p>
                </div>
            </form>
        </div>
    </main>
    <!-- main content end -->

    <!-- FOOTER Section Start -->
    <?php include 'footer.php'; ?>
    <!-- FOOTER Section End -->


    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/loadingscreen.js"></script>

    <!-- Javascripts -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function handleCredentialResponse(response) {
            // Send the response token to your server
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'backend/google-signup.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('Signed in as: ' + xhr.responseText);
                if (xhr.responseText.indexOf('successful') !== -1) {
                    window.location.href = 'home.php'; // Redirect after successful login
                } else {
                    alert(xhr.responseText); // Display error message
                }
            };
            xhr.send('id_token=' + response.credential);
        }
    </script>
</body>

</html>