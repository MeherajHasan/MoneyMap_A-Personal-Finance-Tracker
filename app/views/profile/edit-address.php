<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/userModel.php');

$currentAddress = $_SESSION['user']['address'];

$errorMSG = "";
$successMSG = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newAddress = trim($_POST['address'] ?? '');

    if (empty($newAddress)) {
        $errorMSG = "Address cannot be empty.";
    } else {
        $valid = true;
        for ($i = 0; $i < strlen($newAddress); $i++) {
            $ch = $newAddress[$i];
            if (!(($ch >= 'a' && $ch <= 'z') || ($ch >= 'A' && $ch <= 'Z') || ($ch >= '0' && $ch <= '9') ||
                $ch === ' ' || $ch === ',' || $ch === '.' || $ch === '-' || $ch === '/' ||
                $ch === '(' || $ch === ')' || $ch === '#')) {
                $valid = false;
                break;
            }
        }

        if (!$valid) {
            $errorMSG = "Address contains invalid characters.";
        } else {
            $addressUpdate = updateUserAddress($_SESSION['user'], $newAddress);
            if ($addressUpdate) {
                $successMSG = "Address updated successfully.";
                $_SESSION['user']['address'] = $newAddress;
                $currentAddress = $newAddress;
                header("Location: profile.php");
                exit();
            } else {
                $errorMSG = "Failed to update address. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Address</title>
    <link rel="stylesheet" href="../../styles/profile/edit-address.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" />
    </header>

    <main>
        <h1>Edit Address</h1>
        <form id="edit-address" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <p><strong>Current Address: </strong> <span id="current-address"><?= $currentAddress ?></span></p>

            <label for="address"><strong>New Address: </strong></label>
            <textarea id="address" name="address" class="address" rows="4"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>

            <p id="errorMSG" style="color:red;"><?php echo $errorMSG; ?></p>
            <?php if ($successMSG): ?>
                <p style="color:green;"><?php echo $successMSG; ?></p>
            <?php endif; ?>

            <div class="btn-container">
                <button type="submit" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/edit-address.js"></script>
</body>

</html>