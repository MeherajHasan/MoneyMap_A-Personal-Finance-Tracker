<?php
session_start();

$name = $email = $subject = $message = $captcha = "";
$nameError = $emailError = $subjectError = $messageError = $captchaError = "";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $_SESSION['captcha_answer'] = $num1 + $num2;
    $_SESSION['captcha_question'] = "What is $num1 + $num2?";
}

$captcha_question = $_SESSION['captcha_question'] ?? "Please solve the CAPTCHA";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $isValid = true;

    if (empty($_POST["name"])) {
        $nameError = "Full name is required.";
        $isValid = false;
    } else {
        $name = trim($_POST["name"]);

        for ($i = 0; $i < strlen($name); $i++) {
            $c = $name[$i];
            if (!(($c >= 'a' && $c <= 'z') ||
                  ($c >= 'A' && $c <= 'Z') ||
                  ($c >= '0' && $c <= '9') ||
                  $c === ' ' || $c === '.' || $c === ',' || $c === '-')) {
                $nameError = "Full name contains invalid characters.";
                $isValid = false;
                break;
            }
        }
    }

    if (empty($_POST["email"])) {
        $emailError = "Email is required.";
        $isValid = false;
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format.";
            $isValid = false;
        }
    }

    if (empty($_POST["subject"])) {
        $subjectError = "Subject is required.";
        $isValid = false;
    } else {
        $subject = trim($_POST["subject"]);
    }

    if (empty($_POST["message"])) {
        $messageError = "Message is required.";
        $isValid = false;
    } else {
        $message = trim($_POST["message"]);
    }

    if (empty($_POST["captcha"])) {
        $captchaError = "CAPTCHA is required.";
        $isValid = false;
    } else {
        $captcha = trim($_POST["captcha"]);
        if (!isset($_SESSION['captcha_answer']) || $captcha != $_SESSION['captcha_answer']) {
            $captchaError = "Incorrect CAPTCHA answer.";
            $isValid = false;
        }
    }

    if ($isValid) {
        // db
        header("Location: confirmation.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact Us</title>
    <link rel="stylesheet" href="../../styles/contact/contact.css" type="text/css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/png" />
</head>

<body>
    <header>
        <div id="moneyMap-logo">
            <img src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" />
        </div>
    </header>

    <main class="contact-container">
        <h1>Contact Us</h1>
        <p>Have questions or feedback? Fill out the form below and we'll get back to you!</p>

        <form id="contactForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
            <p id="nameError"><?= $nameError ?></p>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
            <p id="emailError"><?= $emailError ?></p>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($subject) ?>">
            <p id="subjectError"><?= $subjectError ?></p>

            <label for="message">Your Message:</label>
            <textarea id="message" name="message" rows="6"><?= htmlspecialchars($message) ?></textarea>
            <p id="messageError"><?= $messageError ?></p>

            <label for="captcha">CAPTCHA:</label>
            <div id="captchaDisplay"><?= htmlspecialchars($captcha_question) ?></div>
            <input type="text" id="captcha" name="captcha">
            <p id="captchaError"><?= $captchaError ?></p>

            <button type="submit" class="btn" id="btn-submit">Submit</button>
            <button type="reset" class="btn" id="btn-reset">Reset</button>

            <?php
                if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
                    $redirectUrl = '../dashboard/dashboard.php';
                } 
                else {
                    $redirectUrl = '../../../public/index.php';
                }
            ?>
            <button type="button" onclick="window.location.href='<?php echo $redirectUrl; ?>'">Cancel</button>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/contact/contact.js"></script>
</body>
</html>
