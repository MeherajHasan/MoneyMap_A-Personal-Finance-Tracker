<?php
include '../../../config/db.php';
session_start();

// Commented out for now, uncomment if you want auto-redirect on active login
// if (isset($_COOKIE['status'])) {
//     if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'admin') {
//         header('Location: ../../views/admin/admin-dashboard.php');
//     } else {
//         header('Location: ../../views/dashboard/dashboard.php');
//     }
//     exit();
// }

$email = "admin@gmail.com"; // Default autofill
$password = "11111111";   // Default autofill
$emailError = $passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email)) {
        $emailError = "Please enter an email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Please enter a valid email address.";
    }

    if (empty($password)) {
        if (empty($emailError)) {
            $passwordError = "Please enter your password.";
        }
    }

    if (empty($emailError) && empty($passwordError)) {
        try {
            // Escape email to prevent SQL injection
            $emailEscaped = mysqli_real_escape_string($con, $email);

            // Adjust field names below according to your DB
            $sql = "SELECT password_hash, role FROM users WHERE mail = '$emailEscaped'";
            $result = mysqli_query($con, $sql);

            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $db_password_hash = $row['password_hash'];
                $role = $row['role'];

                if ($password === $db_password_hash) {      //hashing need to be implemented
                    setcookie("status", "loggedin", time() + 3600, "/");
                    setcookie("role", $role, time() + 3600, "/");

                    if ($role === 'admin') {
                        header('Location: ../../views/admin/admin-dashboard.php');
                    } else {
                        header('Location: ../../views/dashboard/dashboard.php');
                    }
                    exit();
                } else {
                    $passwordError = "Incorrect password.";
                }
            } else {
                $emailError = "Email not recognized.";
            }
        } catch (Exception $e) {
            echo "<div style='color: red; font-size: 18px; text-align: center; margin-top: 20px;'>
                    <strong>Error:</strong> Unable to process your request. Please try again later.
                  </div>";
            exit();
        }
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
            <input id="email" type="email" name="email" placeholder="xyz@gmail.com"
                value="<?php echo htmlspecialchars($email); ?>" />
            <p id="emailError" class="error"><?php echo $emailError; ?></p>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" placeholder="Enter your password"
                value="<?php echo htmlspecialchars($password); ?>" />
            <p id="passwordError" class="error"><?php echo $passwordError; ?></p>

            <div class="remember-me">
                <input id="remember" type="checkbox" name="remember" />
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
</body>
<!--script src="../../validation/auth/login.js"></script>-->

</html>