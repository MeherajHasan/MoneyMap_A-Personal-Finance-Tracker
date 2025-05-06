<?php
    session_start();

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            echo "Please enter both email and password.";
        } else {
            $stored_email = "abc@gmail.com";
            $stored_password = "11111111";  

            if ($email == $stored_email && $password == $stored_password) {
                setcookie('status', 'true', time() + 3600, '/'); 

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
