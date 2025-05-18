<?php

require_once('db.php');

function login($user) {
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE email = '{$user['email']}' AND password = '{$user['password']}'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);  
    } else {
        return false;
    }
}

function signup($user) {
    $con = getConnection();

    // Escape all input fields for security
    $fname = mysqli_real_escape_string($con, $user['fname']);
    $lname = mysqli_real_escape_string($con, $user['lname']);
    $id_type = mysqli_real_escape_string($con, $user['id_type']);
    $id_number = mysqli_real_escape_string($con, $user['id_number']);
    $passport_expiry = mysqli_real_escape_string($con, $user['passport_expiry']);
    $country_code = mysqli_real_escape_string($con, $user['country_code']);
    $phone = mysqli_real_escape_string($con, $user['phone']);
    $email = mysqli_real_escape_string($con, $user['email']);
    $password = $user['password']; 
    $gender = mysqli_real_escape_string($con, $user['gender']);
    $dob = mysqli_real_escape_string($con, $user['dob']);
    $address = mysqli_real_escape_string($con, $user['address']);
    $photo_path = mysqli_real_escape_string($con, $user['photo_path']);
    $account_status = mysqli_real_escape_string($con, $user['account_status']);
    $role = mysqli_real_escape_string($con, $user['role']);

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fname, lname, id_type, id_number, passport_expiry, country_code, phone, email, password, gender, dob, address, photo_path, account_status, role) 
            VALUES ('$fname', '$lname', '$id_type', '$id_number', '$passport_expiry', '$country_code', '$phone', '$email', '$passwordHash', '$gender', '$dob', '$address', '$photo_path', '$account_status', '$role')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>
