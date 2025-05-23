<?php
require_once('db.php');
require_once('expenseCategoryModel.php');

function getAllExpenses($userID) {
    $con = getConnection();
    $sql = "SELECT e.*, c.name AS category_name 
            FROM expenses e
            JOIN expense_categories c ON e.category_id = c.category_id
            WHERE e.userID = '$userID' AND e.status = 0";
    
    $result = mysqli_query($con, $sql);
    $expenses = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $expenses[] = $row;
    }
    return $expenses;
}

function getExpenseTotalsByCategory($userId) {
    $con = getConnection();
    $sql = "SELECT c.name AS category_name, SUM(e.amount) AS total_amount
            FROM expenses e
            JOIN expense_categories c ON e.category_id = c.category_id
            WHERE e.userID = $userId
            GROUP BY c.name";

    $result = mysqli_query($con, $sql);

    $totals = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $totals[$row['category_name']] = $row['total_amount'];
        }
        mysqli_free_result($result);
    }

    return $totals;
}

function addExpense($userID, $category_id, $name, $amount, $note) {
    $con = getConnection();
    $sql = "INSERT INTO expenses (userID, category_id, name, amount, note)
            VALUES ('$userID', '$category_id', '$name', '$amount', '$note')";
    return mysqli_query($con, $sql);
}
?>