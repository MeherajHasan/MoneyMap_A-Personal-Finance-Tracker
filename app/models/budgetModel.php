<?php
require_once 'db.php';
require_once 'expenseCategoryModel.php';
require_once 'expenseModel.php';

function getTotalBudgetMonthly($userId, $yearMonth)
{
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

function getCategoryNameById($categoryId)
{
    $con = getConnection();
    $query = "SELECT name FROM expense_categories WHERE category_id = $categoryId LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
    return 'Unknown';
}

function getSelectedMonthBudgets($userId, $yearMonth)
{
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

function addNewBudget($categoryId, $userId, $amount, $startDate, $endDate, $notes)
{
    $con = getConnection();
    $query = "INSERT INTO budget (category_id, user_id, amount, start_date, target_date, note) 
              VALUES ($categoryId, $userId, $amount, '$startDate', '$endDate', '$notes')";

    return mysqli_query($con, $query);
}

function getBudgetInfoById($budgetId)
{
    $con = getConnection();
    $query = "SELECT * FROM budget WHERE budget_id = $budgetId LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    return null;
}

function updateBudget($budgetId, $categoryId, $amount, $startDate, $endDate, $notes)
{
    $con = getConnection();
    $query = "UPDATE budget 
              SET category_id = $categoryId, amount = $amount, 
                  start_date = '$startDate', target_date = '$endDate', note = '$notes' 
              WHERE budget_id = $budgetId";

    return mysqli_query($con, $query);
}

// function getOverspentCategoriesByUser($userId) {
//     $con = getConnection();
//     $currentMonth = date('m');
//     $currentYear = date('Y');

//     $query = "SELECT ec.name 
//               FROM budget b 
//               JOIN expense_categories ec ON b.category_id = ec.category_id 
//               WHERE b.user_id = $userId 
//                 AND b.status = 2 
//                 AND MONTH(b.target_date) = $currentMonth 
//                 AND YEAR(b.target_date) = $currentYear";

//     $result = mysqli_query($con, $query);

//     $categories = [];
//     if ($result && mysqli_num_rows($result) > 0) {
//         while ($row = mysqli_fetch_assoc($result)) {
//             $categories[] = $row['name'];
//         }
//     }

//     return $categories;
// }

function getOverspentCategoriesByUser($userId)
{
    $con = getConnection();

    $firstDayOfMonth = date('Y-m-01');
    $lastDayOfMonth = date('Y-m-t');

    $query = "
  SELECT ec.name, b.amount, SUM(IFNULL(e.amount, 0)) AS total_spent
  FROM budget b
  JOIN expense_categories ec ON b.category_id = ec.category_id
  LEFT JOIN expenses e
   ON e.category_id = b.category_id
   AND e.userID = b.user_id
   AND e.expense_date BETWEEN b.start_date AND b.target_date
  WHERE b.user_id = $userId
   AND (
   b.start_date <= '$lastDayOfMonth'
   AND b.target_date >= '$firstDayOfMonth'
  )
  GROUP BY b.budget_id
  HAVING total_spent > b.amount
 ";

    $result = mysqli_query($con, $query);

    $categories = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['name'];
        }
    }

    return $categories;
}

function deleteBudgetByCategory($categoryId, $userId)
{
    $con = getConnection();
    $query = "DELETE FROM budget WHERE category_id = $categoryId AND user_id = $userId";
    return mysqli_query($con, $query);
}

function totalBudget($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(amount) AS total_budget FROM budget WHERE user_id = $userId";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total_budget'];
    }
}

function getUserBudgetDataGrouped($userId) {
    $con = getConnection();

    $query = "
        SELECT 
            ec.name AS category_name,
            DATE_FORMAT(b.start_date, '%Y-%m') AS month_label,
            b.amount,
            SUM(IFNULL(e.amount, 0)) AS spent_amount
        FROM budget b
        JOIN expense_categories ec ON b.category_id = ec.category_id
        LEFT JOIN expenses e 
            ON b.category_id = e.category_id
            AND b.user_id = e.userID
            AND e.expense_date BETWEEN b.start_date AND b.target_date
        WHERE b.user_id = $userId
        GROUP BY ec.name, month_label, b.amount
        ORDER BY month_label ASC, ec.name ASC
    ";

    $result = mysqli_query($con, $query);

    $data = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    return $data;
}

function getAllUserTotalBudget()
{
    $con = getConnection();
    $sql = "SELECT SUM(amount) AS total_budget FROM budget";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_budget'];
    }
}

function getUsedBudgetByCategory($userId, $categoryId, $monthYear)
{
    $con = getConnection();
    $month = date('m', strtotime($monthYear));
    $year = date('Y', strtotime($monthYear));

    $sql = "SELECT SUM(amount) AS total_used FROM expenses 
            WHERE userID = $userId 
            AND category_id = $categoryId 
            AND status = 0 
            AND MONTH(expense_date) = $month 
            AND YEAR(expense_date) = $year";

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_used'] ?? 0;
    }
}

function getUsedBudgetMonthly($userId, $month)
{
    $con = getConnection();
    $startDate = $month . '-01';
    $endDate = date('Y-m-t', strtotime($startDate));

    $sql = "SELECT SUM(amount) AS used_budget FROM expenses 
            WHERE userID = $userId 
            AND expense_date BETWEEN '$startDate' AND '$endDate' 
            AND status = 0";

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['used_budget'] ?? 0;
    }
    return 0;
}
