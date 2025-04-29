<?php
session_start();

// Example hardcoded code (same as JS). In real use, get from session or database
$actualCode = "111111";

// Get the submitted code
$submittedCode = isset($_POST['verifyCode']) ? trim($_POST['verifyCode']) : '';

// Initialize error message
$error = "";

// Validation
if (empty($submittedCode)) {
    $error = "Please enter the verification code.";
} elseif (!ctype_digit($submittedCode)) {
    $error = "Code must contain only numbers.";
} elseif (strlen($submittedCode) !== 6) {
    $error = "Code must be exactly 6 digits.";
} elseif ($submittedCode !== $actualCode) {
    $error = "Verification code is incorrect.";
}

// Redirect or show message
if ($error === "") {
    // Code verified successfully
    // You can update user verification status in DB here
    header("Location: success.html"); // or wherever you want to redirect
    exit();
} else {
    // Send back to form with error
    $_SESSION['verify_error'] = $error;
    header("Location: emailVerify.php"); // Use .php so it can read the session
    exit();
}
?>
