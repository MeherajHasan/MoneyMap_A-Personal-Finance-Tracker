<?php
session_start();
require_once('../models/db.php');
require_once('../models/userModel.php');
 
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

unset($_SESSION['emailError'], $_SESSION['passwordError'], $_SESSION['email']);

$hasError = false;

if (empty($email)) {
    $_SESSION['emailError'] = "Email is required!";
    $hasError = true;
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['emailError'] = "Invalid email format!";
    $hasError = true;
} else {
    $_SESSION['email'] = $email;
}

if (empty($password)) {
    $_SESSION['passwordError'] = "Password is required!";
    $hasError = true;
}

if ($hasError) {
    header("Location: ../views/auth/login.php");
    exit();
}

$user = ['email' => $email, 'password' => $password];
$userData = login($user);

if ($userData) {
    $_SESSION['status'] = true;

    foreach ($userData as $key => $value) {
        // if ($key !== 'password') {
            $_SESSION['user'][$key] = $value;
        // }
    }

    if (isset($_POST['remember'])) {
    setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
    setcookie('remember_password', $password, time() + (30 * 24 * 60 * 60), '/'); 
    } else {
    setcookie('remember_email', '', time() - 3600, '/');
    setcookie('remember_password', '', time() - 3600, '/');
    }

    if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin' && $_SESSION['user']['account_status'] == 0) {
        header('Location: ../views/admin/admin-dashboard.php');
    } else if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'user' && $_SESSION['user']['account_status'] == 0) {
        header('Location: ../views/dashboard/dashboard.php');
    } else {
        header('Location: ../views/auth/waiting.php');
    }
} else {
    $_SESSION['passwordError'] = "Invalid email or password!";
    $_SESSION['email'] = $email;
    header('Location: ../views/auth/login.php');
    exit();
}
?>