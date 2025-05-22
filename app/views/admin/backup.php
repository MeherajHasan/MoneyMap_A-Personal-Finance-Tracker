<?php
require_once('../../controllers/adminAuth.php');
include '../../models/userModel.php';

if (isset($_POST['backup'])) {
    backupDatabase();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Backup - MoneyMap</title>
    <link rel="stylesheet" href="../../styles/admin/backup.css">
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon">
</head>
<body>
    <?php include '../header-footer/admin-header.php'; ?>

    <h2>Database Backup</h2>

    <form id="backupForm" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <button type="submit" name="backup">Create Backup</button>
        <p>Click the button above to create a backup of the database. The backup will be downloaded as a .sql file.</p>
    </form>
    <?php include '../header-footer/admin-footer.php'; ?>
</body>

<script src="../../validation/admin/backup.js"></script>
</html>
