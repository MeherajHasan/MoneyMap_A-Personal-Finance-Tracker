<?php
session_start();

if (!isset($_SESSION['photo'])) {
    die("No photo data found in session.");
}

$photo = $_SESSION['photo'];

// Validate again just in case
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($photo['type'], $allowedTypes)) {
    die("Invalid file type.");
}

$uploadDir = __DIR__ . '/../../../uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$photoName = time() . "_" . basename($photo["name"]);
$uploadPath = $uploadDir . $photoName;

if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
    unset($_SESSION['photo']); // Clean up session
    // Redirect to login after success
    header("Location: ../../views/auth/login.php");
    exit();
} else {
    die("Failed to upload image.");
}
