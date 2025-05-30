<?php
require_once('../../controllers/userAuth.php');
require_once('../../models/userModel.php');

$errorMSG = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedReasons = $_POST['reason'] ?? []; 
    $otherDetail = trim($_POST['other-reason-detail'] ?? '');

    $validReasons = [
        "Account is no longer needed",
        "Privacy concerns",
        "Not satisfied with the service"
    ];

    $isValid = false;

    foreach ($selectedReasons as $reason) {
        if (in_array($reason, $validReasons)) {
            $isValid = true;
            break;
        }
    }

    if ($isValid) {
        $deleteStatus = deleteUserAccount($_SESSION['user']);
        if ($deleteStatus) {
            $_SESSION['user']['status'] = 1;
            header("Location: ../../controllers/logout.php");
            exit();
        }
    } elseif (in_array("Other", $selectedReasons)) {
        if (!empty($otherDetail)) {
            $deleteStatus = deleteUserAccount($_SESSION['user']);
            if ($deleteStatus) {
                $_SESSION['user']['status'] = 1;
                header("Location: ../../controllers/logout.php");
                exit();
            }
        } else {
            $errorMSG = "Please provide details for 'Other' reason.";
        }
    } else {
        $errorMSG = "Please select a reason for deleting your account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="../../styles/profile/delete-acc.css">
    <link rel="icon" href="../../../public/assets/logo.png">
</head>

<body>
    <header>
        <img id="MoneyMap-logo" src="../../../public/assets/fullLogo.png" alt="MoneyMap-logo">
    </header>

    <main class="container">
        <h1>Delete Your Account</h1>
        <p>We're sorry to see you go.</p>
        <p>Please mention the reason for deleting your account:</p>

        <form id="accDelete-form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="reason">
                <label><input type="checkbox" name="reason[]" value="Account is no longer needed"> Account is no longer needed</label><br>
                <label><input type="checkbox" name="reason[]" value="Privacy concerns"> Privacy concerns</label><br>
                <label><input type="checkbox" name="reason[]" value="Not satisfied with the service"> Not satisfied with the service</label><br>
                <label><input type="checkbox" name="reason[]" value="Other" id="other-reason"> Other</label>
                
                <div id="other-reason-text" style="display: none;">
                    <textarea name="other-reason-detail" rows="4" cols="50" placeholder="Please specify other reason..."></textarea>
                </div>
            </div>

            <p id="errorMSG" style="color: red;"><?= $errorMSG ?></p>
            
            <button type="submit" class="delete-button">Delete Account</button>
        </form>

        <div class="back-to-dashboard">
            <a href="../../views/dashboard/dashboard.php">Back to Dashboard</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/profile/detele-acc.js"></script>
</body>
</html>
