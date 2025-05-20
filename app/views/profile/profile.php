<?php
    require_once('../../controllers/userAuth.php');

    $photoPath = $_SESSION['user']['photo_path'] ?? '';
    $profileImage = (!empty($photoPath) && file_exists("../{$photoPath}"))
        ? "../{$photoPath}"
        : "../../../public/assets/profile.png";

    $fullName = $_SESSION['user']['fname'] . ' ' . $_SESSION['user']['lname'];

    $idType = $_SESSION['user']['id_type'] === 0 ? 'NID' : 'Passport';
    $idNumber = $_SESSION['user']['id_number'];

    $email = $_SESSION['user']['email'];

    $phone = $_SESSION['user']['phone'];

    $address = $_SESSION['user']['address'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/profile/profile.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main class="profile-container">
        <h1><?= $fullName ?>'s Profile</h1>

        <div class="profile-details">
            <div class="profile-photo">
                <img id="user-photo" class="profile-img" src="<?= $profileImage ?>" alt="Profile Photo">
                <button class="upload edit" id="upload">Upload</button>
            </div>

            <div class="profile-info">
                <p><strong>Full Name:</strong> <span id="full-name"></span><?= $fullName ?></span></p>
                <button class="edit" id="edit-Name">Edit</button>

                <p><strong>Identification Type:</strong> <span id="id-type"><?= $idType ?></span></p>
                <p><strong>NID/Passport Number:</strong> <span id="nid-passport"><?= $idNumber ?></span></p>
                <button class="edit" id="identity-edit">Edit</button>

                <p><strong>Email:</strong> <span id="email"><?= $email ?></span></p>
                <button class="edit" id="mail-edit">Edit</button>

                <p><strong>Phone Number:</strong> <span id="phone"><?= $phone ?></span></p>
                <button class="edit" id="phone-edit">Edit</button>

                <p><strong>Address:</strong> <span id="address"><?= $address ?></span></p>
                <button class="edit" id="address-edit">Edit</button>

                <p><strong>Password:</strong> ********</p>
                <button class="edit" id="password-edit">Change Password</button>
            </div>
        </div>
        </div>
        <div class="delete-acc">
            <button id="delete-acc">Delete Account</button>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/profile.js"></script>
</body>

</html>