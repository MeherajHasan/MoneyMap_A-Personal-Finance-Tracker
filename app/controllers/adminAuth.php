<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin' || $_SESSION['user']['account_status'] != 0) {
    header('Location: ../auth/login.php');
    exit();
}
?>
