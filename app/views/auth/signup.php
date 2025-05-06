<?php
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitize($data) {
        return htmlspecialchars(stripslashes(trim($data)));
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

    // Validate each field
    if (empty($fname)) $errors['fname'] = "First name is required.";
    if (empty($lname)) $errors['lname'] = "Last name is required.";
    if (empty($idType)) $errors['idType'] = "Identification type is required.";
    if (empty($idInput)) $errors['idInput'] = ucfirst($idType) . " number is required.";
    if ($idType === 'passport' && empty($passportExpiry)) $errors['passportExpiry'] = "Passport expiry date is required.";
    if (empty($countryCode) || empty($phone)) $errors['phone'] = "Phone number with country code is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "A valid email is required.";
    if (strlen($password) < 8) $errors['password'] = "Password must be at least 8 characters.";
    if ($password !== $confirmPassword) $errors['confirmPassword'] = "Passwords do not match.";
    if (empty($gender)) $errors['gender'] = "Gender is required.";
    if (empty($dob)) $errors['dob'] = "Date of birth is required.";
    if (empty($address)) $errors['address'] = "Address is required.";

    // Validate photo upload
    if ($photo && $photo['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($photo['type'], $allowedTypes)) {
            $errors['photo'] = "Only JPG, PNG, and GIF images are allowed.";
        }
    } else {
        $errors['photo'] = "Photo upload is required.";
    }

    // If no errors, proceed
    if (empty($errors)) {
        // Move uploaded photo to target directory
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $photoName = basename($photo["name"]);
        $targetFilePath = $targetDir . time() . "_" . $photoName;
        move_uploaded_file($photo["tmp_name"], $targetFilePath);

        // Set cookies (example: store user's name and email)
        setcookie("fname", $fname, time() + 3600, "/");
        setcookie("email", $email, time() + 3600, "/");

        // Normally, here you'd save data to a database
        $success = true;
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
            <p style="color: green;">Registration successful! Cookies have been set.</p>
        <?php endif; ?>
        <form action="" method="post" id="signupForm" enctype="multipart/form-data">
            <label for="fname">First Name:</label>
            <input id="fname" type="text" name="fname" value="<?= htmlspecialchars($_POST['fname'] ?? '') ?>" placeholder="First Name" />
            <p id="fnameError"><?= $errors['fname'] ?? '' ?></p>

            <label for="lname">Last Name:</label>
            <input id="lname" type="text" name="lname" value="<?= htmlspecialchars($_POST['lname'] ?? '') ?>" placeholder="Last Name" />
            <p id="lnameError"><?= $errors['lname'] ?? '' ?></p>

            <label for="idType">Identification Type:</label>
            <select id="idType" name="idType" onchange="handleIDSelection()">
                <option value="" disabled <?= empty($_POST['idType']) ? 'selected' : '' ?>>-- Select Identification Type --</option>
                <option value="nid" <?= ($_POST['idType'] ?? '') === 'nid' ? 'selected' : '' ?>>NID</option>
                <option value="passport" <?= ($_POST['idType'] ?? '') === 'passport' ? 'selected' : '' ?>>Passport</option>
            </select>
            <p id="idTypeError"><?= $errors['idType'] ?? '' ?></p>

            <div id="idInputContainer" class="<?= empty($_POST['idType']) ? 'hidden' : '' ?>">
                <label id="idLabel" for="idInput"><?= ucfirst($_POST['idType'] ?? '') ?> Number:</label>
                <input id="idInput" type="text" name="idInput" value="<?= htmlspecialchars($_POST['idInput'] ?? '') ?>" placeholder="<?= ucfirst($_POST['idType'] ?? '') ?> Number" />
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
                            $selected = ($_POST['countryCode'] ?? '') === $code ? 'selected' : '';
                            echo "<option value=\"$code\" $selected>$code</option>";
                        }
                        ?>
                    </select>
                    <input id="phone" type="number" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" placeholder="Phone Number" />
                </div>
                <p id="phoneError"><?= $errors['phone'] ?? '' ?></p>
            </div>

            <label for="mail">Email:</label>
            <input id="mail" type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="xyz@gmail.com" />
            <p id="mailError"><?= $errors['email'] ?? '' ?></p>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" placeholder="8 characters minimum" />
            <p id="passError"><?= $errors['password'] ?? '' ?></p>

            <label for="confirmPassword">Confirm Password:</label>
            <input id="confirmPassword" type="password" name="confirmPassword" placeholder="8 characters minimum" />
            <p id="confirmPassError"><?= $errors['confirmPassword'] ?? '' ?></p>

            <fieldset>
                <legend>Gender: </legend>
                <input id="male" type="radio" name="gender" value="male" <?= ($_POST['gender'] ?? '') === 'male' ? 'checked' : '' ?> />
                <label for="male">Male</label><br>
                <input id="female" type="radio" name="gender" value="female" <?= ($_POST['gender'] ?? '') === 'female' ? 'checked' : '' ?> />
                <label for="female">Female</label>
                <div id="genderError"><?= $errors['gender'] ?? '' ?></div>
            </fieldset>

            <label for="dob">Date of Birth:</label>
            <input id="dob" type="date" name="dob" value="<?= htmlspecialchars($_POST['dob'] ?? '') ?>" />
            <p id="dobError"><?= $errors['dob'] ?? '' ?></p>

            <label for="address">Address: </label>
            <textarea id="address" name="address" rows="2" cols="20" placeholder="Enter your area"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
            <p id="addressError"><?= $errors['address'] ?? '' ?></p>

            <label for="photo">Upload Your Photo:</label>
            <input id="photo" type="file" name="photo" accept="image/*" />
            <p id="photoError"><?= $errors['photo'] ?? '' ?></p>

            <button type="button" onclick="window.location.href='login.php'">Cancel</button>
            <button type="reset" onclick="return confirm('Are you sure you want to reset the form?')">Reset</button>
            <button id="signupSubmitBtn" type="submit">Submit</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 <a id="about" href="../../views/landing/about.html">MoneyMap.</a> All rights reserved.</p>
    </footer>

    <script src="../../validation/auth/signup.js"></script>
</body>
</html>
