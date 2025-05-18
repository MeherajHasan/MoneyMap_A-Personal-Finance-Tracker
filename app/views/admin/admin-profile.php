<?php
session_start();

if (!isset($_COOKIE['status']) || $_COOKIE['role'] !== 'admin') {
    header('Location: ../../views/auth/login.php');
    exit();
}

include '../../../config/db.php';

// Fetch Admin Information
// $adminId = $_COOKIE['user_id'];
// $query = "SELECT full_name, id_type, nid_passport, email, phone, address, linked_accounts FROM users WHERE id = '$adminId'";
// $result = mysqli_query($con, $query);
// $adminData = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/profile/admin-profile.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <?php include '../header-footer/admin-header.php'; ?>

    <main class="profile-container">
        <h1>Admin Profile</h1>

        <form id="admin-profile-form" method="POST" action="">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" value="<?= $adminData['full_name'] ?>">
            </div>

            <div class="form-group">
                <label for="id_type">Identification Type:</label>
                <input type="text" id="id_type" name="id_type" value="<?= $adminData['id_type'] ?>">
            </div>

            <div class="form-group">
                <label for="nid_passport">NID/Passport Number:</label>
                <input type="text" id="nid_passport" name="nid_passport" value="<?= $adminData['nid_passport'] ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= $adminData['email'] ?>">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" value="<?= $adminData['phone'] ?>">
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?= $adminData['address'] ?>">
            </div>

            <div class="form-group">
                <label for="linked_accounts">Linked Accounts:</label>
                <input type="text" id="linked_accounts" name="linked_accounts" value="<?= $adminData['linked_accounts'] ?>">
            </div>

            <button type="button" id="save-profile">Save Changes</button>
        </form>
    </main>

    <?php include '../header-footer/admin-footer.php'; ?>
    <script src="../../validation/admin/admin-profile.js"></script>
</body>
</html>

<?php
// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $id_type = $_POST['id_type'];
    $nid_passport = $_POST['nid_passport'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $linked_accounts = $_POST['linked_accounts'];

    $updateQuery = "UPDATE users SET 
        full_name = '$full_name',
        id_type = '$id_type',
        nid_passport = '$nid_passport',
        email = '$email',
        phone = '$phone',
        address = '$address',
        linked_accounts = '$linked_accounts'
    WHERE id = '$adminId'";

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update profile.');</script>";
    }
}
