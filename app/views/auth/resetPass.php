<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link rel="icon" href="../../../storage/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/auth/resetPass.css">
</head>

<body>

    <header id="header">
        <img src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" id="logo" />
    </header>

    <main>
        <h1>Reset Password</h1>
        <form action="" id="resetPassForm" method="post">
            <label for="newPass">New Password:</label>
            <input id="newPass" type="password" name="newPass" placeholder="Enter new password" />
            <p id="passErrorMSG1"></p>

            <label for="confirmPass">Confirm Password:</label>
            <input id="confirmPass" type="password" name="confirmPass" placeholder="Confirm password" />
            <p id="passErrorMSG2"></p>

            <div class="button-group">
                <button type="submit" id="resetPassBtn">Submit</button>
                <button type="reset">Clear</button>
            </div>
        </form>
        <script src="../../validation/auth/resetPass.js"></script>
    </main>

    <?php include '../header-footer/footer.php' ?>
</body>

</html>