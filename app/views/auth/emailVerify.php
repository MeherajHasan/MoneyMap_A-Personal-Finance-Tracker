<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Verification</title>
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/auth/emailVerify.css">
</head>

<body>

    <header id="header">
        <img src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" id="logo" />
    </header>

    <main id="emailVerifyMain">
        <form action="" id="emailVerifyForm" method="post">
            <h1 id="verificationTitle">Email Verification</h1>
            <label for="verifyCode" class="inputLabel">Enter Verification Code:</label>
            <input id="verifyCode" class="inputField" type="text" name="verifyCode" placeholder="Must be 6 digits" />
            <br>

            <div class="button-group">
                <a href="login.php" class="cancelBtnLink"><button type="button" class="cancelBtn">Cancel</button></a>
                <button type="reset" class="resetBtn">Reset</button>
                <button type="submit" id="verifyConfirmBtn" class="submitBtn" formaction="verify.php">Confirm</button>
            </div>

            <p id="verifyMSG" class="verificationMessage"></p>

            <div class="emailErrorLink">Entered wrong email? <a href="forgetPass.php" class="errorLink">Go back</a>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/auth/emailVerify.js"></script>
</body>

</html>