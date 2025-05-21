<?php

require_once('../../controllers/adminAuth.php');
include '../../models/userModel.php';

$searchEmail = '';
$selectedUser = null;
$updateError = "";
$updateSuccess = "";
$searchError = "";
$valid = true;

function isValidName($name)
{
    for ($i = 0; $i < strlen($name); $i++) {
        $char = $name[$i];
        if (!(($char >= 'a' && $char <= 'z') ||
            ($char >= 'A' && $char <= 'Z') ||
            $char === '.' || $char === '-')) {
            return false;
        }
    }
    return true;
}

function isDigitsOnly($str)
{
    for ($i = 0; $i < strlen($str); $i++) {
        $ch = $str[$i];
        if ($ch < '0' || $ch > '9') {
            return false;
        }
    }
    return true;
}

// search user
if (isset($_POST['search'])) {
    $searchEmail = trim($_POST['searchEmail']);

    if (empty($searchEmail)) {
        $searchError = "Email field is required";
    } elseif (!filter_var($searchEmail, FILTER_VALIDATE_EMAIL)) {
        $searchError = "Invalid email address";
    } else {
        $selectedUser = searchByMail($searchEmail);
    }
}

// update User
if (isset($_POST['update'])) {
    $updateError = "";
    $valid = true;
    $email = trim($_POST['email']);
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = trim($_POST['address']);
    $account_status = $_POST['account_status'];
    $role = $_POST['role'];

    if ($fname === '') {
        $updateError = "First name is required";
        $valid = false;
    } elseif (!isValidName($fname)) {
        $updateError = "First name must contain only letters";
        $valid = false;
    } elseif ($lname === '') {
        $updateError = "Last name is required";
        $valid = false;
    } elseif (!isValidName($lname)) {
        $updateError = "Last name must contain only letters";
        $valid = false;
    } elseif ($phone === '') {
        $updateError = "Phone number is required";
        $valid = false;
    } elseif (!isDigitsOnly($phone)) {
        $updateError = "Phone number must be digits only";
        $valid = false;
    } elseif (strlen($phone) < 6) {
        $updateError = "Phone number must be at least 6 digits";
        $valid = false;
    } elseif ($gender === '') {
        $updateError = "Gender is required";
        $valid = false;
    } elseif (!in_array($gender, ['0', '1'])) {
        $updateError = "Invalid gender selected";
        $valid = false;
    } elseif ($address === '') {
        $updateError = "Address is required";
        $valid = false;
    } elseif ($dob === '') {
        $updateError = "Date of birth is required";
        $valid = false;
    } elseif (strtotime($dob) > strtotime('-12 years')) {
        $updateError = "User must be at least 12 years old";
        $valid = false;
    } elseif ($account_status === '') {
        $updateError = "Account status is required";
        $valid = false;
    } elseif (!in_array($account_status, ['0', '2'])) {
        $updateError = "Invalid account status";
        $valid = false;
    } elseif ($role === '') {
        $updateError = "Role is required";
        $valid = false;
    } elseif (!in_array($role, ['admin', 'user'])) {
        $updateError = "Invalid role selected"; 
        $valid = false;
    }

    if ($valid) {
        $updateUser = updateUserInfo_byAdmin($email, $fname, $lname, $phone, $gender, $dob, $address, $account_status, $role);

        if ($updateUser) {
            $selectedUser = $updateUser;
            $updateSuccess = "User updated successfully!";
        } else {
            $updateError = "Error updating user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Management</title>
    <link rel="stylesheet" href="../../styles/admin/user-management.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/admin-header.php' ?>

    <h2>User Management</h2>

    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <input type="text" name="searchEmail" placeholder="Search by Email" value="<?= $searchEmail ?>" />
        <button type="submit" name="search">Search</button> <br>
        <p id="searchError"><?= $searchError ?></p>
    </form>

    <!-- Edit Form -->
    <?php if ($selectedUser): ?>
        <h3>Edit User Information</h3>
        <form method="post">           
            <p id="updateError"><?= $updateError ?></p>
            <p id="updateSuccess"><?= $updateSuccess ?></p>
            <input type="hidden" name="email" value="<?= $selectedUser['email'] ?>" />
            <label>First Name:</label><input type="text" name="fname" value="<?= $selectedUser['fname'] ?>" /><br />
            <label>Last Name:</label><input type="text" name="lname" value="<?= $selectedUser['lname'] ?>" /><br />
            <label>Phone:</label><input type="text" name="phone" value="<?= $selectedUser['phone'] ?>" /><br />
            <label>Gender:</label>
            <select name="gender">
                <option value="0" <?= $selectedUser['gender'] == 0 ? 'selected' : '' ?>>Male</option>
                <option value="1" <?= $selectedUser['gender'] == 1 ? 'selected' : '' ?>>Female</option>
            </select><br />
            <label>Date of Birth:</label><input type="date" name="dob" value="<?= $selectedUser['dob'] ?>" /><br />
            <label>Address:</label><input type="text" name="address" value="<?= $selectedUser['address'] ?>" /><br />
            <label>Account Status:</label>
            <select name="account_status">
                <option value="0" <?= $selectedUser['account_status'] == 0 ? 'selected' : '' ?>>Active</option>
                <!-- <option value="1" <?= $selectedUser['account_status'] == 1 ? 'selected' : '' ?>>Inactive</option> -->
                <option value="2" <?= $selectedUser['account_status'] == 2 ? 'selected' : '' ?>>Suspend</option>
                <!-- <option value="3" <?= $selectedUser['account_status'] == 3 ? 'selected' : '' ?>>Pending</option> -->
            </select><br />
            <label>Role:</label>
            <select name="role">
                <option value="admin" <?= $selectedUser['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $selectedUser['role'] == 'user' ? 'selected' : '' ?>>User</option>
            </select><br />
            <button type="submit" name="update">Save Changes</button>
        </form>
    <?php endif; ?>

    <!-- Grid Views -->
    <?php
    $tables = fetchUserCategoryWise();

    foreach ($tables as $title => $result) {
        echo "<h3>$title:</h3>";
        echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th></tr>";
        foreach ($result as $row) {
            echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['fname']} {$row['lname']}</td>
            <td>{$row['email']}</td>
            <td>{$row['role']}</td>
            <td>{$row['account_status']}</td>
        </tr>";
        }
        echo "</table>";
    }
    ?>
    <?php include '../header-footer/admin-footer.php' ?>
</body>

<script src="../../validation/admin/user-management.js"></script>

</html>
