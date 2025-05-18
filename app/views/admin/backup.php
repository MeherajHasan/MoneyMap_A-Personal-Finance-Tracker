<?php
require_once('../../controllers/adminAuth.php');

include '../../../config/db.php';

if (isset($_POST['backup'])) {
    // Database configuration
    $dbHost = '127.0.0.1';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'moneymap';

    // Set the filename as 'backup_moneymap.sql'
    $backupFile = "backup_moneymap.sql";

    // Execute the mysqldump command to generate the SQL file
    $command = "mysqldump --user=$dbUsername --password=$dbPassword --host=$dbHost $dbName > $backupFile";
    exec($command);

    // If the file is generated, trigger download
    if (file_exists($backupFile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($backupFile));
        header('Content-Length: ' . filesize($backupFile));
        readfile($backupFile);

        // Remove the file from the server after download
        unlink($backupFile);
        exit();
    } else {
        echo "<script>alert('Backup failed. Please try again.');</script>";
    }
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

    <form id="backupForm" method="post">
        <button type="submit" name="backup">Create Backup</button>
    </form>

    <?php include '../header-footer/admin-footer.php'; ?>
</body>

<script src="../../validation/admin/backup.js"></script>
</html>
