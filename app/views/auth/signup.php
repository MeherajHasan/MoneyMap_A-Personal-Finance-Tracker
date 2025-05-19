<?php
require_once('../../models/db.php');

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function sanitize($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    function isOnlyLettersAndSpaces($str) {
        for ($i = 0; $i < strlen($str); $i++) {
            $c = $str[$i];
            if (!(($c >= 'A' && $c <= 'Z') || ($c >= 'a' && $c <= 'z') || $c === ' ')) {
                return false;
            }
        }
        return true;
    }

    function isAlphanumeric($str) {
        for ($i = 0; $i < strlen($str); $i++) {
            $c = $str[$i];
            if (!(($c >= 'A' && $c <= 'Z') || ($c >= 'a' && $c <= 'z') || ($c >= '0' && $c <= '9'))) {
                return false;
            }
        }
        return true;
    }

    function isDigitsOnly($str) {
        for ($i = 0; $i < strlen($str); $i++) {
            if (!($str[$i] >= '0' && $str[$i] <= '9')) {
                return false;
            }
        }
        return true;
    }

    function isValidEmailSimple($email) {
        $atPos = strpos($email, '@');
        $dotPos = strrpos($email, '.');
        if ($atPos === false || $dotPos === false) {
            return false;
        }
        return ($atPos < $dotPos) && ($atPos > 0) && ($dotPos < strlen($email) - 1);
    }

    function isAtLeast12YearsOld($dob) {
        $dobDate = strtotime($dob);
        if (!$dobDate) return false;
        $twelveYearsAgo = strtotime('-12 years');
        return $dobDate <= $twelveYearsAgo;
    }

    $fname = sanitize($_POST['fname'] ?? '');
    $lname = sanitize($_POST['lname'] ?? '');
    $idType = $_POST['idType'] ?? '';
    $idInput = sanitize($_POST['idInput'] ?? '');
    $passportExpiry = $_POST['passportExpiry'] ?? '';
    $countryCode = $_POST['countryCode'] ?? '';
    $phone = sanitize($_POST['phone'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $address = sanitize($_POST['address'] ?? '');
    $photo = $_FILES['photo'] ?? null;

    if (empty($fname)) {
        $errors['fname'] = "First name is required.";
    } elseif (!isOnlyLettersAndSpaces($fname)) {
        $errors['fname'] = "First name must contain only letters and spaces.";
    }

    if (empty($lname)) {
        $errors['lname'] = "Last name is required.";
    } elseif (!isOnlyLettersAndSpaces($lname)) {
        $errors['lname'] = "Last name must contain only letters and spaces.";
    }

    if (empty($idType)) {
        $errors['idType'] = "Identification type is required.";
    }

    if (empty($idInput)) {
        $errors['idInput'] = ucfirst($idType) . " number is required.";
    } else {
        $len = strlen($idInput);
        if ($len < 6 || $len > 20) {
            $errors['idInput'] = ucfirst($idType) . " number must be 6 to 20 characters long.";
        } elseif (!isAlphanumeric($idInput)) {
            $errors['idInput'] = ucfirst($idType) . " number must contain only letters and numbers.";
        }
    }

    if ($idType === 'passport') {
        if (empty($passportExpiry)) {
            $errors['passportExpiry'] = "Passport expiry date is required.";
        } elseif (strtotime($passportExpiry) <= strtotime(date('Y-m-d'))) {
            $errors['passportExpiry'] = "Passport expiry date must be greater than today.";
        }
    }

    if (empty($countryCode)) {
        $errors['countryCode'] = "Country code is required.";
    }

    if (empty($phone)) {
        $errors['phone'] = "Phone number is required.";
    } else {
        $len = strlen($phone);
        if ($len < 6 || $len > 15) {
            $errors['phone'] = "Phone number must be 6 to 15 digits.";
        } elseif (!isDigitsOnly($phone)) {
            $errors['phone'] = "Phone number must contain only digits.";
        }
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!isValidEmailSimple($email)) {
        $errors['email'] = "Email must be valid and contain '@' and '.' with '@' before '.'";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters.";
    }

    if (empty($confirmPassword)) {
        $errors['confirmPassword'] = "Confirm Password is required.";
    } elseif ($password !== $confirmPassword) {
        $errors['confirmPassword'] = "Passwords do not match.";
    }

    if (empty($gender)) {
        $errors['gender'] = "Gender is required.";
    }

    if (empty($dob)) {
        $errors['dob'] = "Date of birth is required.";
    } elseif (!isAtLeast12YearsOld($dob)) {
        $errors['dob'] = "You must be at least 12 years old.";
    }

    if (empty($address)) {
        $errors['address'] = "Address is required.";
    }

    if ($photo && $photo['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($photo['type'], $allowedTypes)) {
            $errors['photo'] = "Only JPG, PNG, and GIF images are allowed.";
        }
    } else {
        $errors['photo'] = "Photo upload is required.";
    }
}
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

        <form action="../../controllers/auth/uploadImage.php" method="post" id="signupForm" enctype="multipart/form-data">
            <label for="fname">First Name:</label>
            <input id="fname" type="text" name="fname" value="<?= htmlspecialchars($_POST['fname'] ?? 'Meheraj') ?>" placeholder="First Name" />
            <p id="fnameError"><?= $errors['fname'] ?? '' ?></p>

            <label for="lname">Last Name:</label>
            <input id="lname" type="text" name="lname" value="<?= htmlspecialchars($_POST['lname'] ?? 'Hasan') ?>" placeholder="Last Name" />
            <p id="lnameError"><?= $errors['lname'] ?? '' ?></p>

            <label for="idType">Identification Type:</label>
            <select id="idType" name="idType" onchange="handleIDSelection()">
                <option value="" disabled>-- Select Identification Type --</option>
                <option value="nid" <?= (!isset($_POST['idType']) || $_POST['idType'] === 'nid') ? 'selected' : '' ?>>NID</option>
                <option value="passport" <?= ($_POST['idType'] ?? '') === 'passport' ? 'selected' : '' ?>>Passport</option>
            </select>
            <p id="idTypeError"><?= $errors['idType'] ?? '' ?></p>

            <div id="idInputContainer" class="<?= empty($_POST['idType']) ? '' : '' ?>">
                <label id="idLabel" for="idInput">NID Number:</label>
                <input id="idInput"
                    type="text"
                    name="idInput"
                    value="<?= htmlspecialchars($_POST['idInput'] ?? '1111111111') ?>"
                    placeholder="Enter NID Number" />
                <p id="idError"><?= $errors['idInput'] ?? '' ?></p>
            </div>

            <div id="passportExpiryContainer" class="<?= ($_POST['idType'] ?? '') === 'passport' ? '' : 'hidden' ?>">
                <label for="passportExpiry">Passport Expiry Date:</label>
                <input id="passportExpiry" type="date" name="passportExpiry" value="<?= htmlspecialchars($_POST['passportExpiry'] ?? '') ?>" />
                <p id="passportExpiryError"><?= $errors['passportExpiry'] ?? '' ?></p>
            </div>


            <div class="phone-container">
                <label for="phone">Phone Number:</label>
                <div class="phone-input">
                    <select id="countryCode" name="countryCode">
                        <option value="" disabled <?= empty($_POST['countryCode']) ? 'selected' : '' ?>>-- Select --</option>
                        <?php
                        $codes = ['+880', '+65', '+1', '+44', '+91'];
                        foreach ($codes as $code) {
                            $selected = ($_POST['countryCode'] ?? '+880') === $code ? 'selected' : '';
                            echo "<option value=\"$code\" $selected>$code</option>";
                        }
                        ?>
                    </select>
                    <input id="phone" type="number" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '11111111') ?>" placeholder="Phone Number" />
                </div>
                <p id="phoneError"><?= $errors['phone'] ?? '' ?></p>
            </div>

            <label for="mail">Email:</label>
            <input id="mail" type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? 'xyz@gmail.com') ?>" placeholder="xyz@gmail.com" />
            <p id="mailError"><?= $errors['email'] ?? '' ?></p>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" placeholder="8 characters minimum" value="<?= htmlspecialchars($_POST['password'] ?? '11111111') ?>" />
            <p id="passError"><?= $errors['password'] ?? '' ?></p>

            <label for="confirmPassword">Confirm Password:</label>
            <input id="confirmPassword" type="password" name="confirmPassword" placeholder="8 characters minimum" value="<?= htmlspecialchars($_POST['confirmPassword'] ?? '11111111') ?>" />
            <p id="confirmPassError"><?= $errors['confirmPassword'] ?? '' ?></p>

            <fieldset>
                <legend>Gender: </legend>

                <input id="male" type="radio" name="gender" value="male" <?= ($_POST['gender'] ?? 'male') === 'male' ? 'checked' : '' ?> />
                <label for="male">Male</label><br>

                <input id="female" type="radio" name="gender" value="female" <?= ($_POST['gender'] ?? '') === 'female' ? 'checked' : '' ?> />
                <label for="female">Female</label>

                <div id="genderError"><?= $errors['gender'] ?? '' ?></div>
            </fieldset>

            <label for="dob">Date of Birth:</label>
            <input id="dob" type="date" name="dob" value="<?= htmlspecialchars($_POST['dob'] ?? '2002-10-30') ?>" />
            <p id="dobError"><?= $errors['dob'] ?? '' ?></p>

            <label for="address">Address: </label>
            <textarea id="address" name="address" rows="2" cols="20" placeholder="Enter your area"><?= htmlspecialchars($_POST['address'] ?? 'Nikunja-2, Dhaka') ?></textarea>
            <p id="addressError"><?= $errors['address'] ?? '' ?></p>

            <label for="photo">Upload Your Photo:</label>
            <input id="photo" type="file" name="photo" accept="image/*" />
            <p id="photoError"><?= $errors['photo'] ?? '' ?></p>

            <button type="button" onclick="window.location.href='login.php'">Cancel</button>
            <button type="reset" onclick="return confirm('Are you sure you want to reset the form?')">Reset</button>
            <button id="signupSubmitBtn" type="submit" name="submit" value="submit">Submit</button>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/auth/signup.js"></script>
</body>

</html>