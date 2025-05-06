<?php
    session_start();

    if (!isset($_COOKIE['status'])) {
        header('Location: ../../views/auth/login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../../styles/contact/contact.css" type="text/css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/png">
</head>

<body>
    <header>
        <div id="moneyMap-logo"><img src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo"></div>
    </header>

    <main class="contact-container">
        <h1>Contact Us</h1>
        <p>Have questions or feedback? Fill out the form below and we'll get back to you!</p>

        <form id="contactForm" action="" method="POST">
            <label for="name">Full Name: </label>
            <input type="text" id="name" name="name">
            <p id="nameError"></p>

            <label for="email">Email Address: </label>
            <input type="email" id="email" name="email">
            <p id="emailError"></p>

            <label for="subject">Subject: </label>
            <input type="text" id="subject" name="subject">
            <p id="subjectError"></p>

            <label for="message">Your Message: </label>
            <textarea id="message" name="message" rows="6"></textarea>
            <p id="messageError"></p>

            <label for="captcha">CAPTCHA: </label>
            <div id="captchaDisplay"></div>
            <input type="text" id="captcha" name="captcha">
            <p id="captchaError"></p>
            <button type="submit" class="btn" id="btn-submit">Submit</button>
            <button type="reset" class="btn" id="btn-reset">Reset</button>
            <button type="button" onclick="window.location.href='../../../public/index.html'">Cancel</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 <a id="about" href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/contact/contact.js"></script>
</body>
</html>