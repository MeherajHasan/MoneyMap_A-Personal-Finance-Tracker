<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Status</title>
    <link rel="stylesheet" href="../../styles/auth/waiting.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>
<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>
    
    <main>
        <div class="waiting-container">
        <h1>Your Account is not active!</h1>
        <p>Your account is currently <strong>inactive</strong>, <strong>pending approval</strong>, or has been <strong>suspended</strong>.  
        Please contact the admin if you believe this is a mistake or have any questions.</p>
        <a id="contactAdminBtn" class="contact-btn">Contact Admin</a>
    </div>
    </main>

    <?php include '../header-footer/footer.php'; ?>

    <script src="../../validation/auth/waiting.js"></script>
</body>
</html>
