<?php
session_start();

require_once('../models/db.php');
require_once('../models/userModel.php');

function sanitize($data) {
    return htmlspecialchars(trim($data));
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

$errors = [];

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

if (!empty($errors)) {
    $_SESSION['signup_errors'] = $errors;
    $_SESSION['signup_old'] = $_POST;
    header("Location: ../views/auth/signup.php");
    exit;
}

$src = $photo['tmp_name'];
$ext = pathinfo($photo['name'], PATHINFO_EXTENSION);
$emailName = strstr($email, '@', true);
$newFileName = $emailName . '.' . $ext;
$des = "../../uploads/" . $newFileName;

if (move_uploaded_file($src, $des)) {
     $user = [
        'fname' => $fname,
        'lname' => $lname,
        'id_type' => $idType === 'nid' ? 0 : 1,
        'id_number' => $idInput,
        'passport_expiry' => $idType === 'passport' ? $passportExpiry : null,
        'country_code' => $countryCode,
        'phone' => $phone,
        'email' => $email,
        'password' => $password,
        'gender' => $gender === 'male' ? 0 : 1,
        'dob' => $dob,
        'address' => $address,
        'photo_path' => $des
    ];
    if (signup($user)) {
        header("Location: ../views/auth/waiting.php");
        exit;
    } 
    else {
        echo "<script>
            alert('Error: Failed to register user. Please try again.');
            window.history.back();
        </script>";
    }
} 
else {
    echo "<script>
        alert('Error: Image upload failed. Please try again.');
        window.history.back();
    </script>";
}
?>