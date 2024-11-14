<?php


if(isset($_POST['logout'])){
    session_start();
    session_unset();
    header('location: login.php');
}


?>