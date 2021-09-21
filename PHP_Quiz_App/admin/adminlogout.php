<?php
require_once '../pdo.php';
    session_start();
    unset($_SESSION['admin_logged_in']);
    session_destroy();
    header("Location:./adminlogin.php");
?>