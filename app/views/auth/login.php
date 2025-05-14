<?php
session_start();
if (isset($_COOKIE['status'])) {
    header('Location: dashboard.php');
    exit();
}

$email = $password = '';
$emailError = $passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email)) {
        $emailError = "Please enter an email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please enter a valid email address.";
    } elseif ($email !== "xyz@gmail.com") {
        $emailError = "Email not recognized.";
    }

    if (empty($password)) {
        if (empty($emailError)) {
            $passwordError = "Please enter your password.";
        }
    } elseif ($password !== "11111111") {
        if (empty($emailError)) {
            $passwordError = "Incorrect password.";
        }
    }

    if (empty($emailError) && empty($passwordError)) {
        setcookie("status", "loggedin", time() + 3600, "/");
        header('Location: ../../views/dashboard/dashboard.php');
        exit();
    }
}
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
        <form action="login.php" method="POST" id="loginForm">
            <label for="email">Email:</label>
            <input id="email" type="email" name="email" placeholder="xyz@gmail.com" value="xyz@gmail.com" /> <!--value="<?php echo htmlspecialchars($email); ?>"-->
            <p id="emailError" class="error"><?php echo $emailError; ?></p>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" placeholder="Enter your password" value="11111111"/>
            <p id="passwordError" class="error"><?php echo $passwordError; ?></p>

            <div class="remember-me">
                <input id="remember" type="checkbox" name="remember" />
                <label for="remember">Remember me</label>
            </div>

            <p><a href="forgetPass.html">Forgot Password?</a></p>

            <div class="button-group">
                <button type="button" onclick="window.location.href='../../../public/index.php'">Cancel</button>
                <button type="reset">Reset</button>
                <button type="submit" id="loginSubmitBtn">Login</button>
            </div>

            <p>Don't have an account? <a href="signup.php">Register here</a></p>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 <a id="about" href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <!--<script src="../../validation/auth/login.js"></script>--> 
</body>

</html>
