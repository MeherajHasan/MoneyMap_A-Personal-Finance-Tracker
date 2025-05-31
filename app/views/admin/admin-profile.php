<?php
require_once('../../controllers/adminAuth.php');
require_once('../../models/userModel.php');


$UpdateMSG = '';
$fullNameError = '';
$mailError = '';
$phoneError = '';
$addressError = '';
$passwordError = '';
$confirmPasswordError = '';
$currentPasswordError = '';

$photoPath = $_SESSION['user']['photo_path'] ?? '';
$profileImage = (!empty($photoPath) && file_exists("../{$photoPath}"))
    ? "../{$photoPath}"
    : "../../../public/assets/profile.png";

$fullName = $_SESSION['user']['fname'] . ' ' . $_SESSION['user']['lname'];
$email = $_SESSION['user']['email'];
$phone = $_SESSION['user']['phone'];
$address = $_SESSION['user']['address'];
$password = $_SESSION['user']['password'];

function isNameValid($name)
{
    for ($i = 0; $i < strlen($name); $i++) {
        $c = $name[$i];
        if (!(($c >= 'a' && $c <= 'z') || ($c >= 'A' && $c <= 'Z') || $c === ' ')) {
            return false;
        }
    }
    return true;
}

function isEmailValid($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isPhoneValid($phone)
{
    if ($phone === '') return false;
    for ($i = 0; $i < strlen($phone); $i++) {
        if (!($phone[$i] >= '0' && $phone[$i] <= '9')) {
            return false;
        }
    }
    if (strlen($phone) < 8 || strlen($phone) > 15) {
        return false;
    } 
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newFullName = trim($_POST['name']);
    $newEmail = trim($_POST['email']);
    $newPhone = trim($_POST['phone']);
    $newAddress = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $enteredCurrentPassword = $_POST['current-password'];

    if ($enteredCurrentPassword === '') {
        $currentPasswordError = 'Current password is required.';
    } elseif (!password_verify($enteredCurrentPassword, $_SESSION['user']['password'])) {
        $currentPasswordError = 'Current password is incorrect.';
    }

    if ($newFullName === '') {
        $fullNameError = 'Full Name is required.';
    } elseif (!isNameValid($newFullName)) {
        $fullNameError = 'Name can only contain letters and spaces.';
    } elseif (count(explode(' ', $newFullName)) < 2) {
        $fullNameError = 'Full Name must contain first and last name.';
    }

    if ($newEmail === '') {
        $mailError = 'Email is required.';
    } elseif (!isEmailValid($newEmail)) {
        $mailError = 'Invalid email format.';
    }

    if ($newPhone === '') {
        $phoneError = 'Phone number is required.';
    } elseif (!isPhoneValid($newPhone)) {
        $phoneError = 'Phone number must be 8-15 DIGITS only.';
    }

    if ($newAddress === '') {
        $addressError = 'Address is required.';
    }

    if ($password !== '') {
        if (strlen($password) < 8) {
            $passwordError = 'Password must be at least 8 characters.';
        }
        if ($password !== $confirm_password) {
            $confirmPasswordError = 'Passwords do not match.';
        }
    }

    $hasErrors = false;
    if ($fullNameError || $mailError || $phoneError || $addressError || $passwordError || $confirmPasswordError || $currentPasswordError) {
        $hasErrors = true;
    } else {
        $hasErrors = false;
    }

    if (!$hasErrors) {
        $newFName = explode(' ', $newFullName)[0];
        $newLName = explode(' ', $newFullName)[1];

        if ($password !== '') {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $passwordHash = $_SESSION['user']['password'];
        }

        $adminUpdate = updateAdminInfo($_SESSION['user'], $newFName, $newLName, $newEmail, $newPhone, $newAddress, $passwordHash);
        if (!$adminUpdate) {
            $UpdateMSG = 'Failed to update profile. Please try again.';
        } else if ($adminUpdate === "duplicate") {
             $mailError = "This email is already used by another account.";
        } else {
            $_SESSION['user']['fname'] = $newFName;
            $_SESSION['user']['lname'] = $newLName;
            $_SESSION['user']['email'] = $newEmail;
            $_SESSION['user']['phone'] = $newPhone;
            $_SESSION['user']['address'] = $newAddress;
            $_SESSION['user']['password'] = $passwordHash;

            $UpdateMSG = "Profile updated successfully."; 

            header("Location: admin-dashboard.php");
            exit();
        } 
    } else {
        $UpdateMSG = 'Please fix the errors above.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Profile - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/admin/admin-profile.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>

<body>
    <?php include '../header-footer/admin-header.php'; ?>

    <main class="profile-container">
        <h1>Admin Profile</h1>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data"
            class="profile-form">
            <div class="profile-photo">
                <img id="admin-photo" src="<?= $profileImage ?>" alt="Admin Photo" />
            </div>

            <div class="profile-info">
                <label for="name"><strong>Full Name:</strong></label>
                <input type="text" id="name" name="name" value="<?= $fullName ?>" />
                <p style="color: red"> <?= $fullNameError ?></p>

                <label for="email"><strong>Email:</strong></label>
                <input type="email" id="email" name="email" value="<?= $email ?>" />
                <p style="color: red"> <?= $mailError ?></p>

                <label for="phone"><strong>Phone Number:</strong></label>
                <input type="text" id="phone" name="phone" value="<?= $phone ?>" />
                <p style="color: red"> <?= $phoneError ?></p>

                <label for="address"><strong>Address:</strong></label>
                <textarea id="address" name="address" rows="3"><?= $address ?></textarea>
                <p style="color: red"> <?= $addressError ?></p>

                <label for="password"><strong>New Password:</strong></label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current" />
                <p style="color: red"> <?= $passwordError ?></p>

                <label for="confirm-password"><strong>Confirm Password:</strong></label>
                <input type="password" id="confirm-password" name="confirm-password"
                    placeholder="Leave blank to keep current" />
                <p style="color: red"> <?= $confirmPasswordError ?></p>

                <label for="current-password"><strong style="color: red;">* Enter your current password for saving the
                        changes:</strong></label>
                <input type="password" id="current-password" name="current-password" />
                <p style="color: red"> <?= $currentPasswordError ?></p>

                <p style="color: red"><?= $UpdateMSG ?></p>

                <div class="form-buttons">
                    <button type="submit" class="save-btn">Save Changes</button>
                    <button type="reset" class="reset-btn">Reset</button>
                </div>
            </div>
        </form>
    </main>

    <?php include '../header-footer/admin-footer.php'; ?>
    <script src="../../validation/admin/admin-profile.js"></script>
</body>

</html>