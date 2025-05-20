<?php
require_once('../../controllers/adminAuth.php');

$adminData = [
    'photo' => '../../../public/assets/admin-default.png',
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'phone' => '01234567890',
    'address' => 'Admin Office, Headquarters',
];

$errors = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'password' => '',
    'confirm_password' => '',
    'photo' => '',
];
$old = $adminData;

function isNameValid($name) {
    if ($name === '') return false;
    for ($i = 0; $i < strlen($name); $i++) {
        $c = $name[$i];
        if (!(($c >= 'a' && $c <= 'z') || ($c >= 'A' && $c <= 'Z') || $c === ' ')) {
            return false;
        }
    }
    return true;
}

function isEmailValid($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isPhoneValid($phone) {
    if ($phone === '') return false;
    for ($i = 0; $i < strlen($phone); $i++) {
        if (!($phone[$i] >= '0' && $phone[$i] <= '9')) {
            return false;
        }
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name'] = trim($_POST['name'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $old['phone'] = trim($_POST['phone'] ?? '');
    $old['address'] = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';

    if ($old['name'] === '') {
        $errors['name'] = 'Full Name is required.';
    } elseif (!isNameValid($old['name'])) {
        $errors['name'] = 'Name can only contain letters and spaces.';
    }

    if ($old['email'] === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!isEmailValid($old['email'])) {
        $errors['email'] = 'Invalid email format.';
    }

    if ($old['phone'] === '') {
        $errors['phone'] = 'Phone number is required.';
    } elseif (!isPhoneValid($old['phone'])) {
        $errors['phone'] = 'Phone number must be digits only.';
    }

    if ($password !== '') {
        if (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters.';
        }
        if ($password !== $confirm_password) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }
    }

    // if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
    //     $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    //     if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    //         $errors['photo'] = 'Error uploading photo.';
    //     } elseif (!in_array($_FILES['photo']['type'], $allowedTypes)) {
    //         $errors['photo'] = 'Only JPG, PNG, GIF images are allowed.';
    //     } elseif ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
    //         $errors['photo'] = 'Photo must be less than 2MB.';
    //     }
    // }

    $hasErrors = false;
    foreach ($errors as $e) {
        if ($e !== '') {
            $hasErrors = true;
            break;
        }
    }

    // if (!$hasErrors) {
    //     if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    //         $uploadDir = '../../../uploads/admin_photos/';
    //         if (!is_dir($uploadDir)) {
    //             mkdir($uploadDir, 0755, true);
    //         }
    //         $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    //         $newFileName = 'admin_photo_' . time() . '.' . $ext;
    //         $uploadPath = $uploadDir . $newFileName;

    //         if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
    //             $old['photo'] = '../../../uploads/admin_photos/' . $newFileName;
    //         }
    //     }

        // db

        if ($password !== '') {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            // Save passwordHash to DB (not implemented)
        }

        $adminData = $old;
        echo "<script>alert('Profile updated successfully!');</script>";
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
<style>
.error { color: red; font-size: 0.9em; margin-top: 2px; }
.profile-photo img { max-width: 150px; border-radius: 5px; }
</style>
</head>
<body>
<?php include '../header-footer/admin-header.php'; ?>

<main class="profile-container">
<h1>Admin Profile</h1>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data" class="profile-form">
    <div class="profile-photo">
        <img id="admin-photo" src="<?= htmlspecialchars($old['photo']) ?>" alt="Admin Photo" />
        <input type="file" name="photo" id="photo" accept="image/*" />
        <?php if ($errors['photo']): ?>
            <div class="error"><?= htmlspecialchars($errors['photo']) ?></div>
        <?php endif; ?>
    </div>

    <div class="profile-info">
        <label for="name"><strong>Full Name:</strong></label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name']) ?>" />
        <?php if ($errors['name']): ?>
            <div class="error"><?= htmlspecialchars($errors['name']) ?></div>
        <?php endif; ?>

        <label for="email"><strong>Email:</strong></label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" />
        <?php if ($errors['email']): ?>
            <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
        <?php endif; ?>

        <label for="phone"><strong>Phone Number:</strong></label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($old['phone']) ?>" />
        <?php if ($errors['phone']): ?>
            <div class="error"><?= htmlspecialchars($errors['phone']) ?></div>
        <?php endif; ?>

        <label for="address"><strong>Address:</strong></label>
        <textarea id="address" name="address" rows="3"><?= htmlspecialchars($old['address']) ?></textarea>

        <label for="password"><strong>New Password:</strong></label>
        <input type="password" id="password" name="password" placeholder="Leave blank to keep current" />
        <?php if ($errors['password']): ?>
            <div class="error"><?= htmlspecialchars($errors['password']) ?></div>
        <?php endif; ?>

        <label for="confirm-password"><strong>Confirm Password:</strong></label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Leave blank to keep current" />
        <?php if ($errors['confirm_password']): ?>
            <div class="error"><?= htmlspecialchars($errors['confirm_password']) ?></div>
        <?php endif; ?>

        <div class="form-buttons">
            <button type="submit" class="save-btn">Save Changes</button>
            <button type="reset" class="reset-btn">Reset</button>
        </div>
    </div>
</form>
</main>

<?php include '../header-footer/admin-footer.php'; ?>
</body>
</html>
