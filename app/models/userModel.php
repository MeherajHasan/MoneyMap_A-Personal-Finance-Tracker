<?php

require_once('db.php');

function login($user) {
    $con = getConnection();

    $email = $user['email'];
    $password = $user['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        $dbUser = mysqli_fetch_assoc($result);
        //if (password_verify($password, $dbUser['password'])) {  // actual

        // CHECKING PURPOSE 
        if ($password === $dbUser['password']) {
            return $dbUser;
        }
    }
    return false;
}

function signup($user) {
    $con = getConnection();

    $fname = $user['fname'];
    $lname = $user['lname'];
    $id_type = $user['id_type'];  // 0->NID or 1->Passport
    $id_number = $user['id_number'];
    $passport_expiry = $user['passport_expiry'] ?? null; 
    $country_code = $user['country_code'];
    $phone = $user['phone'];
    $email = $user['email'];
    $password = $user['password']; 
    $gender = $user['gender']; // for male 0, for female 1
    $dob = $user['dob'];
    $address = $user['address'];
    $photo_path = $user['photo_path'];
    $created_at = date('Y-m-d H:i:s');     //current time
    $account_status = 3; // by default 3 -> pending
    $role = "user"; // by default 'user'

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (id, fname, lname, id_type, id_number, passport_expiry, country_code, phone, email, password, gender, dob, address, photo_path, created_at, account_status, role) 
            VALUES (null, '$fname', '$lname', '$id_type', '$id_number', '$passport_expiry', '$country_code', '$phone', '$email', '$passwordHash', '$gender', '$dob', '$address', '$photo_path', '$created_at', '$account_status', '$role')";

    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

?>
