<?php
session_start();
if(isset($_SESSION['email'])) {
    unset($_SESSION['role']);
    unset($_SESSION['email']);
    unset($_SESSION['userId']);
    header("Location: ../views/login.php");
}
?>