<?php
require_once('../../controllers/adminAuth.php');
include '../../models/userModel.php';

$searchEmail = '';
$selectedUser = null;
$updateError = "";
$updateSuccess = "";
$searchError = "";
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Management</title>
    <link rel="stylesheet" href="../../styles/admin/user-management.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/admin-header.php' ?>

    <h2>User Management</h2>

    <form id="searchForm">
        <input type="text" name="searchEmail" placeholder="Search by Email" />
        <button type="submit">Search</button> <br>
        <p id="searchError"></p>
    </form>

    <div id="editUserFormContainer"></div>
    <p id="updateError"></p>
    <p id="updateSuccess"></p>

    <?php
    $tables = fetchUserCategoryWise();

    foreach ($tables as $title => $result) {
        echo "<h3>$title:</h3>";
        echo "<table border='1'><tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                </tr>";
        foreach ($result as $row) {
            echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['fname']} {$row['lname']}</td>
            <td>{$row['email']}</td>
            <td>{$row['role']}</td>
            <td>{$row['account_status']}</td>
        </tr>";
        }
        echo "</table>";
    }
    ?>
    <?php include '../header-footer/admin-footer.php' ?>
</body>

<script src="../../validation/admin/user-management.js"></script>

</html>