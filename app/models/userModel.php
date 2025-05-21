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
        if (password_verify($password, $dbUser['password'])) { 
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

function updateUserName($user, $newFirstName, $newLastName) {
    $con = getConnection();
    $email = $user['email'];
    $newFirstName = $newFirstName;
    $newLastName = $newLastName;
    $sql = "UPDATE users SET fname = '$newFirstName', lname = '$newLastName' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

function updateUserIdentity($user, $newIdType, $newIdNumber) {
    $con = getConnection();
    $email = $user['email'];
    $idTypeValue = ($newIdType === 'NID') ? 0 : 1;

    $sql = "UPDATE users SET id_type = '$idTypeValue', id_number = '$newIdNumber' WHERE email = '$email'";

    try {
        return mysqli_query($con, $sql);
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            return "duplicate";
        }
        return false;
    }
}


function updateUserEmail($user, $newEmail) {
    $con = getConnection();
    $email = $user['email'];
    $newEmail = $newEmail;
    $sql = "UPDATE users SET email = '$newEmail' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

function updateUserPhone($user, $newPhone) {
    $con = getConnection();
    $email = $user['email'];
    $newPhone = $newPhone;
    $sql = "UPDATE users SET phone = '$newPhone' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

function updateUserAddress($user, $newAddress) {
    $con = getConnection();
    $email = $user['email'];
    $newAddress = $newAddress;
    $sql = "UPDATE users SET address = '$newAddress' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

function updateUserPassword($user, $newPassword) {
    $con = getConnection();
    $email = $user['email'];
    $sql = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

function deleteUserAccount($user) {
    $con = getConnection();
    $email = $user['email'];
    $sql = "UPDATE users SET account_status = 1 WHERE email = '$email'";
    return mysqli_query($con, $sql);
}
?>
