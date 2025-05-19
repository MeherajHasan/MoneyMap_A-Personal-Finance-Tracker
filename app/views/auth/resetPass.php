<?php
require_once('../../models/db.php');

$newPass = "";
$confirmPass = "";
$passError1 = "";
$passError2 = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPass = trim($_POST["newPass"] ?? "");
    $confirmPass = trim($_POST["confirmPass"] ?? "");

    if (empty($newPass)) {
        $passError1 = "New password is required.";
    } elseif (strlen($newPass) < 8) {
        $passError1 = "Password must be at least 8 characters.";
    }

    if (empty($confirmPass)) {
        $passError2 = "Confirm password is required.";
    } elseif ($newPass !== $confirmPass) {
        $passError2 = "Passwords do not match.";
    }

    if (empty($passError1) && empty($passError2)) {
        // db and hashing

        $successMsg = "Password has been successfully reset.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link rel="icon" href="../../../storage/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/auth/resetPass.css" />
</head>

<body>

    <header id="header">
        <img src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" id="logo" />
    </header>

    <main>
        <h1>Reset Password</h1>
        <form action="" id="resetPassForm" method="post" novalidate>
            <label for="newPass">New Password:</label>
            <input id="newPass" type="password" name="newPass" placeholder="Enter new password" value="<?php echo htmlspecialchars($newPass); ?>" />
            <p id="passErrorMSG1" style="color:red;"><?php echo $passError1; ?></p>

            <label for="confirmPass">Confirm Password:</label>
            <input id="confirmPass" type="password" name="confirmPass" placeholder="Confirm password" value="<?php echo htmlspecialchars($confirmPass); ?>" />
            <p id="passErrorMSG2" style="color:red;"><?php echo $passError2; ?></p>

            <div class="button-group">
                <button type="submit" id="resetPassBtn">Submit</button>
                <button type="reset">Clear</button>
            </div>

            <?php if ($successMsg): ?>
                <p style="color:green; margin-top:10px;"><?php echo $successMsg; ?></p>
            <?php endif; ?>
        </form>

        <script src="../../validation/auth/resetPass.js"></script>
    </main>

    <?php include '../header-footer/footer.php' ?>
</body>

</html>
