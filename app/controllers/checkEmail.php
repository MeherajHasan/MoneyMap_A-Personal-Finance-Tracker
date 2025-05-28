<?php
require_once('../models/userModel.php');
header('Content-Type: application/json'); 

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $con = getConnection();
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['available' => false]);
    } else {
        echo json_encode(['available' => true]);
    }
} 
?>
