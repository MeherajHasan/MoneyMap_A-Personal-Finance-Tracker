<?php
require_once('../../models/db.php');

$verifyCode = "";
$verifyCodeError = "";
$verifyMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $verifyCode = trim($_POST["verifyCode"] ?? "");

    if (empty($verifyCode)) {
        $verifyCodeError = "Verification code is required.";
    } elseif (!ctype_digit($verifyCode) || strlen($verifyCode) !== 6) {
        $verifyCodeError = "Verification code must be exactly 6 digits.";
    } else {
        //  db
        
        // hardcoded code
        $correctCode = "123456";

        if ($verifyCode === $correctCode) {
            $verifyMsg = "Verification successful! You can now log in.";
            header("Location: resetPass.php");
            exit();
        } else {
            $verifyCodeError = "Invalid verification code. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Email Verification</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/auth/emailVerify.css" />
</head>

<body>

    <header id="header">
        <img src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" id="logo" />
    </header>

    <main id="emailVerifyMain">
        <form action="" id="emailVerifyForm" method="post" novalidate>
            <h1 id="verificationTitle">Email Verification</h1>
            <label for="verifyCode" class="inputLabel">Enter Verification Code:</label>
            <input id="verifyCode" class="inputField" type="text" name="verifyCode" placeholder="Must be 6 digits"
                value="<?php echo htmlspecialchars($verifyCode); ?>" />
            <br>
            <?php if ($verifyCodeError): ?>
                <p style="color:red; margin-top:4px;"><?php echo $verifyCodeError; ?></p>
            <?php endif; ?>

            <div class="button-group">
                <a href="login.php" class="cancelBtnLink"><button type="button" class="cancelBtn">Cancel</button></a>
                <button type="reset" class="resetBtn">Reset</button>
                <button type="submit" id="verifyConfirmBtn" class="submitBtn">Confirm</button>
            </div>

            <?php if ($verifyMsg): ?>
                <p id="verifyMSG" class="verificationMessage" style="color:green;"><?php echo $verifyMsg; ?></p>
            <?php endif; ?>

            <div class="emailErrorLink">Entered wrong email? <a href="forgetPass.php" class="errorLink">Go back</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/auth/emailVerify.js"></script>
</body>

</html>
