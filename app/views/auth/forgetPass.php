<?php
require_once('../../models/db.php');

$email = "";
$emailError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");

    if (empty($email)) {
        $emailError = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
    } else {
        // db
        
        header("Location: emailVerify.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../../styles/auth/forgetPass.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" />
    </header>

    <main>
        <h1>Forgot Password</h1>
        <form id="forgetForm" action="" method="post" novalidate>
            <label for="email">Enter your email:</label>
            <input
                id="email"
                type="text"
                name="email"
                placeholder="xyz@gmail.com"
                value="<?php echo htmlspecialchars($email); ?>"
            />
            <br />
            <?php if ($emailError): ?>
                <p style="color:red; margin-top:4px;"><?php echo $emailError; ?></p>
            <?php endif; ?>

            <div class="button-group">
                <button type="button" onclick="window.location.href='login.php'">Cancel</button>
                <button id="forgotSubmitBtn" type="submit">Submit</button>
            </div>

            <p>Remembered your password? <a href="login.php">Login here</a></p>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/auth/forgetPass.js"></script>
</body>

</html>
