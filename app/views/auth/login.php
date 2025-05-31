<?php
session_start();
require_once('../../models/db.php');

$email = $_SESSION['email'] ?? '';
if (isset($_COOKIE['remember_email'])) {
    $email = $_COOKIE['remember_email'];
}

$password = $_SESSION['password'] ?? '';
if (isset($_COOKIE['remember_password'])) {
    $password = $_COOKIE['remember_password'];
}

$emailError = $_SESSION['emailError'] ?? '';
$passwordError = $_SESSION['passwordError'] ?? '';
session_unset();
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>
    <link rel="stylesheet" href="../../styles/auth/login.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Login Form</h1>
        <form action="../../controllers/loginCheck.php" method="POST" id="loginForm">
            <label for="email">Email:</label>
            <input id="email" type="email" name="email" placeholder="xyz@gmail.com"
                value="<?= $email; ?>" />
            <p id="emailError" class="error"><?= $emailError; ?></p>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" placeholder="Enter your password"
                value="<?= $password; ?>" />
            <p id="passwordError" class="error"><?= $passwordError; ?></p>

            <div class="remember-me">
                <input id="remember" type="checkbox" name="remember" <?= isset($_COOKIE['remember_email']) ? 'checked' : ''; ?> />
                <label for="remember">Remember me</label>
            </div>

            <p><a href="forgetPass.php">Forgot Password?</a></p>

            <div class="button-group">
                <button type="button" onclick="window.location.href='../../../public/index.php'">Cancel</button>
                <button type="reset">Reset</button>
                <button type="submit" id="loginSubmitBtn">Login</button>
            </div>

            <p>Don't have an account? <a href="signup.php">Register here</a></p>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>
    <script src="../../validation/auth/login.js"></script>
</body>

</html>