<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}
?>
