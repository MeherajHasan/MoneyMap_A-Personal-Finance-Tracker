<?php
require_once('../../controllers/userAuth.php');

$errorMSG = '';
$successMSG = '';

$currentPhone = $_SESSION['user']['phone']; 

$currentPhoneDisplay = $currentPhone;

function isDigitsOnly($str) {
    for ($i = 0; $i < strlen($str); $i++) {
        $ch = $str[$i];
        if ($ch < '0' || $ch > '9') {
            return false;
        }
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPhone = trim($_POST['phone']);

    if ($newPhone === '') {
        $errorMSG = 'New phone number is required.';
    } elseif ($newPhone === $currentPhone) {
        $errorMSG = 'New phone number must be different from the current phone number.';
    } elseif (!isDigitsOnly($newPhone)) {
        $errorMSG = 'Phone number can contain digits only.';
    } elseif (strlen($newPhone) < 6) {
        $errorMSG = 'Phone number must be at least 6 digits.';
    } else {
        // db

        $successMSG = 'Phone number updated successfully.';
        $currentPhoneDisplay = $newPhone;
        $_POST = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Phone Number</title>
    <link rel="stylesheet" href="../../styles/profile/edit-phone.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" />
    </header>

    <main>
        <h1>Edit Phone Number</h1>
        <form id="edit-phone" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <p><strong>Current Phone Number: </strong> <span id="current-phone"><?php echo $currentPhoneDisplay; ?></span></p>

            <label for="phone"><strong>New Phone Number: </strong></label>
            <input type="tel" id="phone" name="phone" class="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" />

            <p id="errorMSG" style="color:red;"><?php echo htmlspecialchars($errorMSG); ?></p>
            <p id="successMSG" style="color:green;"><?php echo htmlspecialchars($successMSG); ?></p>

            <div class="btn-container">
                <button type="submit" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php'; ?>

    <script src="../../validation/profile/edit-phone.js"></script>
</body>

</html>
