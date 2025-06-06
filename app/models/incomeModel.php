<?php
require_once('db.php');

function addIncome($userId, $incomeType, $source, $amount, $incomeDate, $note) {
    $con = getConnection();
    $sql = "INSERT INTO income (user_id, income_type, source, amount, income_date, note) 
            VALUES ('$userId', '$incomeType', '$source', '$amount', '$incomeDate', '$note')";
    $result = mysqli_query($con, $sql);
    return $result;
}

function totalRegularMainIncome($userId) {
    $con = getConnection();
    $sql = "SELECT SUM(amount) AS total FROM income WHERE user_id = '$userId' AND income_type = 0 AND income_status = 0";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

function totalRegularSideIncome($userId) {
    $con = getConnection();
    $sql = "SELECT SUM(amount) AS total FROM income WHERE user_id = '$userId' AND income_type = 1 AND income_status = 0";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

function totalIrregularIncome($userId) {
    $con = getConnection();
    $sql = "SELECT SUM(amount) AS total FROM income WHERE user_id = '$userId' AND income_type = 2 AND income_status = 0";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

function totalIncome($userId) {
    $con = getConnection();
    $sql = "SELECT SUM(amount) AS total FROM income WHERE user_id = '$userId' AND income_status = 0";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

function getAllIncome($userId, $dateFilter = '') {
    $con = getConnection();
    $sql = "SELECT * FROM income WHERE user_id = '$userId' AND income_status = 0";

    if (!empty($dateFilter)) {
        $sql .= " AND DATE_FORMAT(income_date, '%Y-%m') = '$dateFilter'";
    }

    $result = mysqli_query($con, $sql);
    return $result;
}

function getRegularMainIncome($userId, $dateFilter = '') {
    $con = getConnection();
    $sql = "SELECT * FROM income WHERE user_id = '$userId' AND income_type = 0 AND income_status = 0";

    if (!empty($dateFilter)) {
        $sql .= " AND DATE_FORMAT(income_date, '%Y-%m') = '$dateFilter'";
    }

    $result = mysqli_query($con, $sql);
    return $result;
}

function getRegularSideIncome($userId, $dateFilter = '') {
    $con = getConnection();
    $sql = "SELECT * FROM income WHERE user_id = '$userId' AND income_type = 1 AND income_status = 0";

    if (!empty($dateFilter)) {
        $sql .= " AND DATE_FORMAT(income_date, '%Y-%m') = '$dateFilter'";
    }

    $result = mysqli_query($con, $sql);
    return $result;
}

function getIrregularIncome($userId, $dateFilter = '') {
    $con = getConnection();
    $sql = "SELECT * FROM income WHERE user_id = '$userId' AND income_type = 2 AND income_status = 0";

    if (!empty($dateFilter)) {
        $sql .= " AND DATE_FORMAT(income_date, '%Y-%m') = '$dateFilter'";
    }

    $result = mysqli_query($con, $sql);
    return $result;
}

function deleteIncome($incomeId) {
    $con = getConnection();
    $sql = "UPDATE income SET income_status = 1 WHERE income_id = '$incomeId'";
    $result = mysqli_query($con, $sql);
    return $result;
}

function getSpecificIncome($incomeId) {
    $con = getConnection();
    $sql = "SELECT * FROM income WHERE income_id = '$incomeId'";
    $result = mysqli_query($con, $sql);
    return $result ? mysqli_fetch_assoc($result) : null;
}

function updateIncome($incomeId, $incomeType, $source, $amount, $incomeDate, $note) {
    $con = getConnection();
    $sql = "UPDATE income SET income_type = $incomeType, source = '$source', amount = '$amount', income_date = '$incomeDate', 
        note = '$note' WHERE income_id = '$incomeId'";
    $result = mysqli_query($con, $sql);
    return $result;
}

function getMonthlyIncomeByType($userID) {
    $con = getConnection();

    $query = "
        SELECT 
            DATE_FORMAT(income_date, '%Y-%m') AS month,
            income_type,
            SUM(amount) AS total_amount
        FROM income
        WHERE user_id = $userID
        GROUP BY month, income_type
        ORDER BY month ASC
    ";

    $result = mysqli_query($con, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function getAllUserTotalIncome() {
    $con = getConnection();
    $sql = "SELECT SUM(amount) AS total_income FROM income WHERE income_status = 0";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_income'];
    } 
}
?>