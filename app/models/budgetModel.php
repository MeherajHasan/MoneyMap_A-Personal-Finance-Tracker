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

function addNewBudget($categoryId, $userId, $amount, $startDate, $endDate, $notes) {
    $con = getConnection();
    $query = "INSERT INTO budget (category_id, user_id, amount, start_date, target_date, note) 
              VALUES ($categoryId, $userId, $amount, '$startDate', '$endDate', '$notes')";
    
    return mysqli_query($con, $query);
}

function getBudgetInfoById($budgetId) {
    $con = getConnection();
    $query = "SELECT * FROM budget WHERE budget_id = $budgetId LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    return null;
}

function updateBudget($budgetId, $categoryId, $amount, $startDate, $endDate, $notes) {
    $con = getConnection();
    $query = "UPDATE budget 
              SET category_id = $categoryId, amount = $amount, 
                  start_date = '$startDate', target_date = '$endDate', note = '$notes' 
              WHERE budget_id = $budgetId";
    
    return mysqli_query($con, $query);
}

function getOverspentCategoriesByUser($userId) {
    $con = getConnection();
    $currentMonth = date('m');
    $currentYear = date('Y');

    $query = "SELECT ec.name 
              FROM budget b 
              JOIN expense_categories ec ON b.category_id = ec.category_id 
              WHERE b.user_id = $userId 
                AND b.status = 2 
                AND MONTH(b.target_date) = $currentMonth 
                AND YEAR(b.target_date) = $currentYear";

    $result = mysqli_query($con, $query);

    $categories = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['name'];
        }
    }

    return $categories;
}

function deleteBudgetByCategory($categoryId, $userId) {
    $con = getConnection();
    $query = "DELETE FROM budget WHERE category_id = $categoryId AND user_id = $userId";
    return mysqli_query($con, $query);
}

?>