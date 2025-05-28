<?php
session_start();
$errors = $_SESSION['signup_errors'] ?? [];
$old = $_SESSION['signup_old'] ?? [];
$success = $_SESSION['signup_success'] ?? false;

unset($_SESSION['signup_errors'], $_SESSION['signup_old'], $_SESSION['signup_success']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Form</title>
    <link rel="stylesheet" href="../../styles/auth/signup.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Registration Form</h1>
        <?php if ($success): ?>
        <p style="color: green;">Registration successful!</p>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
        <div style="background: #ffebee; padding: 10px; margin: 10px; border: 1px solid #ffcdd2;">
            <h3>Errors:</h3>
            <?php foreach ($errors as $error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="../../controllers/signupCheck.php" id="signupForm" method="post" enctype="multipart/form-data">
            <label for="fname">First Name:</label>
            <input id="fname" type="text" name="fname" value="<?= $old['fname'] ?? '' ?>" placeholder="First Name" />
            <p id="fnameError"><?= $errors['fname'] ?? '' ?></p>

            <label for="lname">Last Name:</label>
            <input id="lname" type="text" name="lname" value="<?= $old['lname'] ?? '' ?>" placeholder="Last Name" />
            <p id="lnameError"><?= $errors['lname'] ?? '' ?></p>

            <label for="idType">Identification Type:</label>
            <select id="idType" name="idType" onchange="handleIDSelection()">
                <option value="" disabled <?= empty($old['idType']) ? 'selected' : '' ?>>-- Select Identification Type --</option>
                <option value="nid" <?= ($old['idType'] ?? '') === 'nid' ? 'selected' : '' ?>>NID</option>
                <option value="passport" <?= ($old['idType'] ?? '') === 'passport' ? 'selected' : '' ?>>Passport</option>
            </select>
            <p id="idTypeError"><?= $errors['idType'] ?? '' ?></p>

            <div id="idInputContainer">
                <label id="idLabel" for="idInput">NID Number:</label>
                <input id="idInput" type="text" name="idInput" value="<?= $old['idInput'] ?? ''?>" placeholder="Enter ID Number" />
                <p id="idError"><?= $errors['idInput'] ?? '' ?></p>
            </div>

            <div id="passportExpiryContainer" class="<?= ($old['idType'] ?? '') === 'passport' ? '' : 'hidden' ?>">
                <label for="passportExpiry">Passport Expiry Date:</label>
                <input id="passportExpiry" type="date" name="passportExpiry" value="<?= $old['passportExpiry'] ?? '' ?>" />
                <p id="passportExpiryError"><?= $errors['passportExpiry'] ?? '' ?></p>
            </div>

            <div class="phone-container">
                <label for="phone">Phone Number:</label>
                <div class="phone-input">
                    <select id="countryCode" name="countryCode">
                        <option value="" disabled <?= empty($old['countryCode']) ? 'selected' : '' ?>>-- Select --</option>
                        <?php
                        $codes = ['+88', '+65', '+1', '+44', '+91'];
                        foreach ($codes as $code) {
                            $selected = ($old['countryCode'] ?? '') === $code ? 'selected' : '';
                            echo "<option value=\"$code\" $selected>$code</option>";
                        }
                        ?>
                    </select>
                    <div>
                        <p id="countryCodeError"><?= $errors['countryCode'] ?? '' ?></p>
                    </div>
                </div>
                <input id="phone" type="text" name="phone" value="<?= $old['phone'] ?? '' ?>" placeholder="Phone Number" />
                <p id="phoneError"><?= $errors['phone'] ?? '' ?></p>
            </div>

            <label for="email">Email:</label>
            <input id="email" type="email" name="email" value="<?= $old['email'] ?? '' ?>" placeholder="Email" />
            <p id="emailError"><?= $errors['email'] ?? '' ?></p>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" placeholder="Password" />
            <p id="passwordError"><?= $errors['password'] ?? '' ?></p>

            <label for="confirmPassword">Confirm Password:</label>
            <input id="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm Password" />
            <p id="confirmPasswordError"><?= $errors['confirmPassword'] ?? '' ?></p>

            <label>Gender:</label>
            <label><input type="radio" name="gender" value="male" <?= ($old['gender'] ?? '') === 'male' ? 'checked' : '' ?>> Male</label>
            <label><input type="radio" name="gender" value="female" <?= ($old['gender'] ?? '') === 'female' ? 'checked' : '' ?>> Female</label>
            <label><input type="radio" name="gender" value="other" <?= ($old['gender'] ?? '') === 'other' ? 'checked' : '' ?>> Other</label>
            <p id="genderError"><?= $errors['gender'] ?? '' ?></p>

            <label for="dob">Date of Birth:</label>
            <input id="dob" type="date" name="dob" value="<?= $old['dob'] ?? '' ?>" />
            <p id="dobError"><?= $errors['dob'] ?? '' ?></p>

            <label for="address">Address:</label>
            <textarea id="address" name="address"><?= $old['address'] ?? '' ?></textarea>
            <p id="addressError"><?= $errors['address'] ?? '' ?></p>

            <label for="photo">Upload Photo:</label>
            <input id="photo" type="file" name="photo" />
            <p id="photoError"><?= $errors['photo'] ?? '' ?></p>

            <button type="submit">Register</button>
        </form>
    </main>
</body>

<?php include '../header-footer/footer.php' ?>

<script src="../../validation/auth/signup.js"></script>

</html>
