<?php
require_once('db.php');

function totalBudget($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(amount) AS total_budget FROM budget WHERE user_id = $userId";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) return $row['total_budget'] ?? 0;
}

function totalSpent($userId)
{
    $con = getConnection();
    $query = "
        SELECT SUM(e.amount) AS total_spent
        FROM expenses e
        JOIN budget b ON e.category_id = b.category_id
            AND e.expense_date BETWEEN b.start_date AND b.target_date
        WHERE b.user_id = $userId
    ";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total_spent'] ?? 0;
    }
}

function totalExpense($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(amount) AS total_expense FROM expenses WHERE userID = $userId";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) return $row['total_expense'] ?? 0;
}

function totalIncome($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(amount) AS total_income FROM income WHERE user_id = $userId";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) return $row['total_income'] ?? 0;
}

function totalDebtPaid($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(paid_amount) AS debt_paid FROM debt WHERE user_id = $userId AND status = 0";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) return $row['debt_paid'] ?? 0;
}

function totalDebt($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(total_amount) AS amount FROM debt WHERE user_id = $userId AND status = 1";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) return $row['amount'] ?? 0;
}

function totalSavings($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(saved_amount) AS total_savings FROM savings WHERE user_id = $userId";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) return $row['total_savings'] ?? 0;
}

function totalSavingsGoal($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(target_amount) AS savings_goal FROM savings WHERE user_id = $userId";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) return $row['savings_goal'] ?? 0;
}

function monthlyIncome($userId)
{
    $con = getConnection();
    $months = [];
    $query = "SELECT MONTH(income_date) as m, SUM(amount) as total FROM income WHERE user_id = $userId GROUP BY m";
    $result = mysqli_query($con, $query);
    for ($i = 1; $i <= 12; $i++) $months[$i] = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $months[(int)$row['m']] = (float)$row['total'];
    }
    return array_values($months);
}

function monthlyExpenses($userId)
{
    $con = getConnection();
    $months = [];
    $query = "SELECT MONTH(expense_date) as m, SUM(amount) as total FROM expenses WHERE userID = $userId GROUP BY m";
    $result = mysqli_query($con, $query);
    for ($i = 1; $i <= 12; $i++) $months[$i] = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $months[(int)$row['m']] = (float)$row['total'];
    }
    return array_values($months);
}
