<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPass = isset($_POST['newPass']) ? trim($_POST['newPass']) : '';
    $confirmPass = isset($_POST['confirmPass']) ? trim($_POST['confirmPass']) : '';

    if (empty($newPass) || empty($confirmPass)) {
        die("Both password fields are required.");
    }

    if (strlen($newPass) < 8) {
        die("Password must be at least 8 characters long.");
    }

    if ($newPass !== $confirmPass) {
        die("Passwords do not match.");
    }

    $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);

    // TODO: Save $hashedPassword into the database.
    // Example (using PDO for database interaction):

    /*
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $userId = $_SESSION['user_id']; // assuming you know which user is resetting password

        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => $userId
        ]);

        echo "Password updated successfully.";
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    */

    echo "Password has been reset successfully.";
} else {
    header("Location: ../../views/auth/resetPass.html");
    exit();
}
?>
