<?php
require_once('../../controllers/userAuth.php');

$errorMSG = '';
$successMSG = '';

$currentIdType = $_SESSION['user']['id_type'] === 0 ? 'NID' : 'Passport';
$currentIdNumber = $_SESSION['user']['id_number'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idType = $_POST['id-type'] ?? '';
    $idNumber = trim($_POST['id-number'] ?? '');
    $passportExpiry = $_POST['passport-expiry-date'] ?? '';

    if (empty($idType) || empty($idNumber)) {
        $errorMSG = "Identity type and ID number are required.";
    } elseif ($idType === 'Passport' && empty($passportExpiry)) {
        $errorMSG = "Passport expiry date is required.";
    } else {
        $valid = true;
        for ($i = 0; $i < strlen($idNumber); $i++) {
            $char = $idNumber[$i];
            if (!(('a' <= $char && $char <= 'z') ||
                  ('A' <= $char && $char <= 'Z') ||
                  ('0' <= $char && $char <= '9') )) {
                $valid = false;
                break;
            }
        }

        if (!$valid) {
            $errorMSG = "ID number contains invalid characters.";
        } else {
            // db

            header("Location: profile.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Identity</title>
    <link rel="stylesheet" href="../../styles/profile/edit-identity.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Edit Identity</h1>
        <form id="edit-identity" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <p><strong>Current Identity Type: </strong> <span id="current-idType"><?= $currentIdType ?></span></p>
            <p><strong>Current ID Number: </strong> <span id="current-idNumber"><?= $currentIdNumber ?></span></p>

            <label for="id-type"><strong>New Identity Type: </strong></label>
            <select id="id-type" name="id-type" class="id-type">
                <option value="" disabled <?php if (!isset($_POST['id-type'])) echo 'selected'; ?>>--Select A Type--</option>
                <option value="NID" <?php if ($_POST['id-type'] ?? '' === 'NID') echo 'selected'; ?>>NID</option>
                <option value="Passport" <?php if ($_POST['id-type'] ?? '' === 'Passport') echo 'selected'; ?>>Passport</option>
            </select>
            <br><br>

            <label for="id-number"><strong>New ID Number: </strong></label>
            <input type="text" id="id-number" name="id-number" class="id-number" value="<?php echo htmlspecialchars($_POST['id-number'] ?? ''); ?>">

            <div id="passport-expiry" style="<?php echo ($_POST['id-type'] ?? '') === 'Passport' ? 'display: block;' : 'display: none;'; ?>">
                <label for="passport-expiry-date"><strong>Passport Expiry Date: </strong></label>
                <input type="date" id="passport-expiry-date" name="passport-expiry-date" value="<?php echo htmlspecialchars($_POST['passport-expiry-date'] ?? ''); ?>">
            </div>

            <p id="errorMSG" style="color:red;"><?php echo $errorMSG; ?></p>

            <div class="btn-container">
                <button type="button" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/edit-identity.js"></script>
</body>

</html>
