<?php
require_once('db.php'); 

function getExpenseCategoryName($userID) {
    $con = getConnection();
    $sql = "SELECT * FROM expense_categories 
            WHERE (status = 1 AND user_id = '$userID') 
               OR (status = 0 AND user_id IS NULL)";

    $result = mysqli_query($con, $sql);
    $categoryNames = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryNames[] = $row['name'];
    }
    return $categoryNames;
}

function getExpenseCategoryNameById($categoryID) {
    $con = getConnection();
    $sql = "SELECT name FROM expense_categories 
            WHERE category_id = '$categoryID'";

    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
    return null;
}

function getExpenseCategoryIdByName($userID, $name) {
    $con = getConnection();
    $sql = "SELECT category_id FROM expense_categories 
            WHERE name = '$name' AND (user_id = '$userID' OR user_id IS NULL)";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['category_id'];
    }
    return null;
} 

function getGeneralizedExpenseCategoryName() {
    $con = getConnection();
    $sql = "SELECT * FROM expense_categories 
            WHERE status = 0 AND user_id IS NULL";

    $result = mysqli_query($con, $sql);
    $categoryNames = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryNames[] = $row['name'];
    }
    return $categoryNames;
}

function getSpecificExpenseCategoryName($userID) {
    $con = getConnection();
    $sql = "SELECT * FROM expense_categories 
            WHERE status = 1 AND user_id = '$userID'";

    $result = mysqli_query($con, $sql);
    $categoryNames = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryNames[] = $row['name'];
    }
    return $categoryNames;
}

function getExpenseCategories($userID) {
    $con = getConnection();
    $sql = "SELECT category_id, name, status FROM expense_categories 
            WHERE (status = 0 AND user_id IS NULL) 
               OR (status = 1 AND user_id = '$userID')";

    $result = mysqli_query($con, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

function addExpenseCategory($userID, $categoryName) {
    $con = getConnection();
    $sql = "INSERT INTO expense_categories (user_id, name) VALUES ('$userID', '$categoryName')";
    $result = mysqli_query($con, $sql);
    return $result;
}

function deleteExpenseCategory($categoryID, $userID) {
    $con = getConnection();
    $sql = "UPDATE expense_categories SET status = 2 WHERE category_id = '$categoryID' AND user_id = '$userID'";
    $result = mysqli_query($con, $sql);
    return $result;
}

function renameExpenseCategory($categoryID, $userID, $newName) {
    $con = getConnection();
    $sql = "UPDATE expense_categories SET name = '$newName' WHERE category_id = '$categoryID' AND user_id = '$userID'";

    $result = mysqli_query($con, $sql);
    return $result;
}
?>