<?php
require_once('../../controllers/userAuth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MoneyMap || Budget Categories</title>
    <link rel="stylesheet" href="../../styles/budget/budget-category.css" />
    <link rel="icon" href="../../../public/assets/logo.png" type="image/x-icon" />
</head>

<body>
    <?php include '../header-footer/header.php' ?>

    <main class="main container">
        <div class="section-header">
            <h2>Existing Budget Categories</h2>
        </div>

        <table class="category-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="categoryTableBody">
                <!-- Existing categories will be dynamically populated here -->
                <tr>
                    <td>Groceries</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Utilities</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Transportation</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Entertainment</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Healthcare</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Education</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Emergency Fund</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="section-header">
            <h2>Add New Category</h2>
        </div>

        <div class="add-category">
            <input type="text" id="newCategory" placeholder="Enter new category name" />
            <button id="addCategoryBtn" class="btn btn-primary">Add Category</button>
        </div>
        <p id="emptyError"></p>

        <div class="navigation-buttons">
            <a href="budget-dashboard.php" class="btn btn-secondary">Back to Budget Dashboard</a>
            <a href="add-budget.php" class="btn btn-secondary">Add New Budget</a>
            <a href="budget-report.php" class="btn btn-secondary">View Budget Report</a>
        </div>
    </main>

    <?php include '../header-footer/footer.php' ?>

    <script src="../../validation/budget/budget-category.js"></script>
</body>

</html>