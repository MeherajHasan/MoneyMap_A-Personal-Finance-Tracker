<?php
require_once('../../controllers/adminAuth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Responses - Admin Panel</title>
    <link rel="stylesheet" href="../../styles/admin/contact-response.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/admin-header.php'; ?>

    <div class="container">
        <h2>Contact Responses</h2>
        <a href="admin-dashboard.php" class="btn">← Back to Dashboard</a>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Response Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="response-table-body">
                <!-- Demo data will be injected here by JavaScript -->
            </tbody>
        </table>
    </div>

    <?php include '../header-footer/admin-footer.php'; ?>
</body>

<script src="../../validation/admin/contact-response.js"></script>
</html>