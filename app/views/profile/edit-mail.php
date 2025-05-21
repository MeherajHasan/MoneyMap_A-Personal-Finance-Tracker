<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/userModel.php');

$errorMSG = '';
$successMSG = '';

$currentEmail = $_SESSION['user']['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newEmail = trim($_POST['email'] ?? '');

    if (empty($newEmail)) {
        $errorMSG = "Email is required.";
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMSG = "Invalid email format.";
    } else {
        $mailUpdate = updateUserEmail($_SESSION['user'], $newEmail);
        if ($mailUpdate) {
            $successMSG = "Email updated successfully.";
            $_SESSION['user']['email'] = $newEmail;
            $currentEmail = $newEmail;
            header("Location: profile.php");
        } else {
            $errorMSG = "Failed to update email. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Email</title>
    <link rel="stylesheet" href="../../styles/profile/edit-mail.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main>
        <h1>Edit Email</h1>
        <form id="edit-mail" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <p><strong>Current Email: </strong> <span id="current-email"><?= $currentEmail ?></span></p>

            <label for="email"><strong>New Email: </strong></label>
            <input type="email" id="email" name="email" class="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">

            <p id="errorMSG" style="color:red;"><?php echo $errorMSG; ?></p>
            <p id="successMSG" style="color:green;"><?php echo $successMSG; ?></p>

            <div class="btn-container">
                <button type="submit" class="btn" id="save-btn">Save</button>
                <button type="button" class="btn" id="cancel-btn">Cancel</button>
            </div>
        </form>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/edit-mail.js"></script>
</body>

</html>
