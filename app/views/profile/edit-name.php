<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/userModel.php');

$errorMSG = '';
$successMSG = '';
$currentName = $_SESSION['user']['fname'] . ' ' . $_SESSION['user']['lname'];

function isValidName($name) {
    for ($i = 0; $i < strlen($name); $i++) {
        $char = $name[$i];
        if (!(($char >= 'a' && $char <= 'z') ||
              ($char >= 'A' && $char <= 'Z') ||
              $char === '.' || $char === '-')) {
            return false;
        }
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = trim($_POST['name'] ?? '');

    if ($newName === '') {
        $errorMSG = "Name cannot be empty.";
    } elseif (!isValidName($newName)) {
        $errorMSG = "Name contains invalid characters.";
    } elseif (count(explode(' ', $newName)) < 2) {
        $errorMSG = "Full name must contain at least two parts.";
    } else {
        $nameParts = explode(' ', $newName);
        $newFirstName = $nameParts[0];
        $newLastName = $nameParts[1];

        $nameUpdate = updateUserName($_SESSION['user'], $newFirstName, $newLastName);

        if ($nameUpdate) {
            $successMSG = "Name updated successfully.";
            $_SESSION['user']['fname'] = $newFirstName;
            $_SESSION['user']['lname'] = $newLastName;
            $currentName = $newFirstName . ' ' . $newLastName;
            header("Location: profile.php");
            exit();
        } else {
            $errorMSG = "Failed to update name. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Name</title>
    <link rel="stylesheet" href="../../styles/profile/edit-name.css" />
    <link rel="icon" href="../../../public/assets/logo.png" />
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo" />
    </header>

    <main>
        <h1>Edit Name</h1>
        <form id="edit-name" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <p><strong>Current Name: </strong> <span id="current-name"><?php echo $currentName; ?></span></p>

            <label for="name"><strong>New Name: </strong></label>
            <input type="text" id="name" name="name" class="name" value="<?php echo $_POST['name'] ?? ''; ?>" />

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

    <script src="../../validation/profile/edit-name.js"></script>
</body>

</html>
