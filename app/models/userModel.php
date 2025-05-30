<?php
require_once('db.php');

// loginCheck.php
function login($user)
{
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

// signupCheck.php
function signup($user)
{
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

// edit-name.php
function updateUserName($user, $newFirstName, $newLastName)
{
    $con = getConnection();
    $email = $user['email'];
    $newFirstName = $newFirstName;
    $newLastName = $newLastName;
    $sql = "UPDATE users SET fname = '$newFirstName', lname = '$newLastName' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

// edit-identity.php
function updateUserIdentity($user, $newIdType, $newIdNumber, $passportExpiry)
{
    $con = getConnection();
    $email = $user['email'];
    $idTypeValue = ($newIdType === 'NID') ? 0 : 1;

    if ($newIdType === 'Passport' && !empty($passportExpiry)) {
        $passportExpiryValue = "'$passportExpiry'";
    } else {
        $passportExpiryValue = "NULL";
    }

    $sql = "UPDATE users SET id_type = '$idTypeValue', id_number = '$newIdNumber', passport_expiry = $passportExpiryValue WHERE email = '$email'";

    try {
        return mysqli_query($con, $sql);
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            return "duplicate";
        }
        return false;
    }
}

// edit-mail.php
function updateUserEmail($user, $newEmail)
{
    $con = getConnection();
    $email = $user['email'];
    $newEmail = $newEmail;
    $sql = "UPDATE users SET email = '$newEmail' WHERE email = '$email'";
    try {
        return mysqli_query($con, $sql);
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            return "duplicate";
        }
        return false;
    }
}

// edit-phone.php
function updateUserPhone($user, $newPhone)
{
    $con = getConnection();
    $email = $user['email'];
    $newPhone = $newPhone;
    $sql = "UPDATE users SET phone = '$newPhone' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

// edit-address.php
function updateUserAddress($user, $newAddress)
{
    $con = getConnection();
    $email = $user['email'];
    $newAddress = $newAddress;
    $sql = "UPDATE users SET address = '$newAddress' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

// edit-pass.php
function updateUserPassword($user, $newPassword)
{
    $con = getConnection();
    $email = $user['email'];
    $sql = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

// delete-acc.php
function deleteUserAccount($user)
{
    $con = getConnection();
    $email = $user['email'];
    $sql = "UPDATE users SET account_status = 1 WHERE email = '$email'"; // 1->inactive
    return mysqli_query($con, $sql);
}

function getTotalUsers()
{
    $con = getConnection();
    $sql = "SELECT COUNT(*) as total FROM users";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

// admin-profile.php
function updateAdminInfo($user, $newFirstName, $newLastName, $newEmail, $newPhone, $newAddress, $newPassword)
{
    $con = getConnection();
    $email = $user['email'];
    $sql = "UPDATE users SET fname = '$newFirstName', lname = '$newLastName', email = '$newEmail', phone = '$newPhone', address = '$newAddress', password = '$newPassword' WHERE email = '$email'";

    try {
        return mysqli_query($con, $sql);
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            return "duplicate";
        }
        return false;
    }
}

// user-management.php
function searchByMail($searchEmail)
{
    $con = getConnection();
    $query = "SELECT * FROM users WHERE email = '$searchEmail'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) === 1) {
        $selectedUser = mysqli_fetch_assoc($result);
        return $selectedUser;
    }
    return false;
}

function updateUserInfo_byAdmin($searchEmail, $fname, $lname, $phone, $gender, $dob, $address, $account_status, $role)
{
    $con = getConnection();
    $updateQuery = "UPDATE users SET fname = '$fname', lname = '$lname', phone = '$phone', gender = '$gender', dob = '$dob', address = '$address', 
        account_status = '$account_status', role = '$role' WHERE email = '$searchEmail'";
    $updateUser = mysqli_query($con, $updateQuery);

    if ($updateUser) {
        return searchByMail($searchEmail);
    }
    return false;
}

function fetchUserCategoryWise()
{ 
    $con = getConnection();
    $allUsers = mysqli_query($con, "SELECT * FROM users");
    $adminUsers = mysqli_query($con, "SELECT * FROM users WHERE role = 'admin'");
    $regularUsers = mysqli_query($con, "SELECT * FROM users WHERE role = 'user'");
    $activeUsers = mysqli_query($con, "SELECT * FROM users WHERE account_status = 0");
    $inactiveUsers = mysqli_query($con, "SELECT * FROM users WHERE account_status = 1");
    $suspendedUsers = mysqli_query($con, "SELECT * FROM users WHERE account_status = 2");
    $pendingUsers = mysqli_query($con, "SELECT * FROM users WHERE account_status = 3");

    return [
        'All Users' => $allUsers,
        'Admins' => $adminUsers,
        'Users' => $regularUsers,
        'Active Users' => $activeUsers,
        'Inactive Users' => $inactiveUsers,
        'Suspended Users' => $suspendedUsers,
        'Pending Users' => $pendingUsers
    ];
}

function backupDatabase()
{
    global $dbuser, $dbpass, $host, $dbname;
    $backupFile = "backup_moneymap.sql"; 

    $command = "mysqldump --user=$dbuser --password=$dbpass --host=$host $dbname > $backupFile";
    exec($command, $output, $returnVar);

    if (file_exists($backupFile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($backupFile));
        header('Content-Length: ' . filesize($backupFile));
        readfile($backupFile);

        unlink($backupFile);
        exit();
    } else {
        echo "<script>alert('Backup failed. Please try again.');</script>";
    }
}

function countUsersByStatus($status)
{
    $con = getConnection();
    $sql = "SELECT COUNT(*) AS count FROM users WHERE account_status = '$status'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['count'];
}
?>