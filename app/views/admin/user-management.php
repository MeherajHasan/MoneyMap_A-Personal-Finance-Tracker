<?php

require_once('../../controllers/adminAuth.php');

include '../../../config/db.php';

$searchEmail = '';
$selectedUser = null;
$updateSuccess = false;

// Search User
if (isset($_POST['search'])) {
    $searchEmail = $_POST['searchEmail'];
    $query = "SELECT * FROM users WHERE mail = '$searchEmail'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $selectedUser = mysqli_fetch_assoc($result);
    }
}

// Update User
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $country_code = $_POST['country_code'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $account_status = $_POST['account_status'];
    $role = $_POST['role'];

    $updateQuery = "UPDATE users SET 
        fname = '$fname', 
        lname = '$lname',
        country_code = '$country_code',
        phone = '$phone',
        gender = '$gender',
        dob = '$dob',
        address = '$address',
        account_status = '$account_status',
        role = '$role'
        WHERE id = '$id'";

    if (mysqli_query($con, $updateQuery)) {
        $updateSuccess = true;
        $selectedUser = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM users WHERE id = '$id'"));
    }
}

// Fetch all user categories
$allUsers = mysqli_query($con, "SELECT * FROM users");
$adminUsers = mysqli_query($con, "SELECT * FROM users WHERE role = 'admin'");
$regularUsers = mysqli_query($con, "SELECT * FROM users WHERE role = 'user'");
$activeUsers = mysqli_query($con, "SELECT * FROM users WHERE account_status = 0");
$inactiveUsers = mysqli_query($con, "SELECT * FROM users WHERE account_status = 1");
$suspendedUsers = mysqli_query($con, "SELECT * FROM users WHERE account_status = 2");
$pendingUsers = mysqli_query($con, "SELECT * FROM users WHERE account_status = 3");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../../styles/admin/user-management.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon">
</head>

<body>
    <?php include '../header-footer/admin-header.php' ?>

    <h2>User Management</h2>

    <!-- Search Form -->
    <form method="post">
        <input type="text" name="searchEmail" placeholder="Search by Email" value="<?= $searchEmail ?>">
        <button type="submit" name="search">Search</button>
    </form>

    <!-- Edit Form -->
    <?php if ($selectedUser): ?>
        <h3>Edit User Information</h3>
        <form method="post">
            <input type="hidden" name="id" value="<?= $selectedUser['id'] ?>">
            <label>First Name:</label><input type="text" name="fname" value="<?= $selectedUser['fname'] ?>"><br>
            <label>Last Name:</label><input type="text" name="lname" value="<?= $selectedUser['lname'] ?>"><br>
            <label>Country Code:</label><input type="text" name="country_code" value="<?= $selectedUser['country_code'] ?>"><br>
            <label>Phone:</label><input type="text" name="phone" value="<?= $selectedUser['phone'] ?>"><br>
            <label>Gender:</label>
            <select name="gender">
                <option value="0" <?= $selectedUser['gender'] == 0 ? 'selected' : '' ?>>Male</option>
                <option value="1" <?= $selectedUser['gender'] == 1 ? 'selected' : '' ?>>Female</option>
            </select><br>
            <label>Date of Birth:</label><input type="date" name="dob" value="<?= $selectedUser['dob'] ?>"><br>
            <label>Address:</label><input type="text" name="address" value="<?= $selectedUser['address'] ?>"><br>
            <label>Account Status:</label>
            <select name="account_status">
                <option value="0" <?= $selectedUser['account_status'] == 0 ? 'selected' : '' ?>>Active</option>
                <option value="1" <?= $selectedUser['account_status'] == 1 ? 'selected' : '' ?>>Inactive</option>
                <option value="2" <?= $selectedUser['account_status'] == 2 ? 'selected' : '' ?>>Suspended</option>
                <option value="3" <?= $selectedUser['account_status'] == 3 ? 'selected' : '' ?>>Pending</option>
            </select><br>
            <label>Role:</label>
            <select name="role">
                <option value="admin" <?= $selectedUser['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $selectedUser['role'] == 'user' ? 'selected' : '' ?>>User</option>
            </select><br>
            <button type="submit" name="update">Save Changes</button>
        </form>
    <?php endif; ?>

    <!-- Grid Views -->
    <?php
    $tables = [
        "All Users" => $allUsers,
        "Admin Users" => $adminUsers,
        "Regular Users" => $regularUsers,
        "Active Users" => $activeUsers,
        "Inactive Users" => $inactiveUsers,
        "Suspended Users" => $suspendedUsers,
        "Pending Users" => $pendingUsers
    ];

    foreach ($tables as $title => $result) {
        echo "<h3>$title:</h3>";
        echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['fname']} {$row['lname']}</td>
                <td>{$row['mail']}</td>
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