<?php 
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Please enter both email and password.";
    } else {
        $admin_email = "abc@gmail.com";
        $admin_password = "11111111";

        $user_email = "xyz@gmail.com";
        $user_password = "11111111";

        if ($email === $admin_email && $password === $admin_password) {
            setcookie('status', 'true', time() + 3600, '/'); 
            setcookie('role', 'admin', time() + 3600, '/');
            header('Location: ../../views/admin/admin-dashboard.php');
            exit();

        } elseif ($email === $user_email && $password === $user_password) {
            setcookie('status', 'true', time() + 3600, '/'); 
            setcookie('role', 'user', time() + 3600, '/');
            header('Location: ../../views/dashboard/dashboard.php');
            exit();

        } else {
            echo "Invalid email or password.";
        }
    }
} else {
    echo "Please submit the form with valid data.";
}
?>
