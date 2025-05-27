<?php
require_once 'db.php';

function getTotalBudgetMonthly($userId, $yearMonth) {
    $con = getConnection();
    $startDate = $yearMonth . '-01';
    $endDate = date('Y-m-t', strtotime($startDate));

    $query = "SELECT SUM(amount) AS total_budget FROM budget 
              WHERE user_id = $userId 
              AND start_date <= '$endDate' 
              AND target_date >= '$startDate'";
    
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total_budget'];
    }
    return 0;
}

function getUsedBudgetMonthly($userId, $yearMonth) {
    $con = getConnection();
    $startDate = $yearMonth . '-01';
    $endDate = date('Y-m-t', strtotime($startDate));

    $query = "SELECT SUM(spent_amount) AS total_used FROM budget 
              WHERE user_id = $userId 
              AND start_date <= '$endDate' 
              AND target_date >= '$startDate'";
    
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total_used'];
    }
    return 0;
}

function getCategoryNameById($categoryId) {
    $con = getConnection();
    $query = "SELECT name FROM expense_categories WHERE category_id = $categoryId LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
    return 'Unknown';
}

function getSelectedMonthBudgets($userId, $yearMonth) {
    $con = getConnection();
    $startDate = $yearMonth . '-01';
    $endDate = date('Y-m-t', strtotime($startDate));

    $query = "SELECT * FROM budget 
              WHERE user_id = $userId 
              AND start_date <= '$endDate' 
              AND target_date >= '$startDate'";
    
    $result = mysqli_query($con, $query);
    $budgets = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $budgets[] = $row;
    }
    return $budgets;
}

?>