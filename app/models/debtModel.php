<?php 
require_once 'db.php';

function countTotalActiveDebts($userID) {
    $con = getConnection();
    $query = "SELECT COUNT(*) AS total FROM debt WHERE user_id = $userID AND status = 0";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total'];
    }
}

function sumActiveDebtAmounts($userID) {
    $con = getConnection();
    $query = "SELECT SUM(total_amount) AS total FROM debt WHERE user_id = $userID AND status = 0";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total'];
    }
}

function sumPaidAmounts($userID) {
    $con = getConnection();
    $query = "SELECT SUM(paid_amount) AS total FROM debt WHERE user_id = $userID AND status = 0";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['total'];
    }
}

function getAllActiveDebts($userID) {
    $con = getConnection();
    $query = "SELECT * FROM debt WHERE user_id = $userID AND status = 0";
    $result = mysqli_query($con, $query);
    $debts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $debts[] = $row;
    }
    return $debts;
}

function getAllDebts($userID) {
    $con = getConnection();
    $query = "SELECT * FROM debt WHERE user_id = $userID";
    $result = mysqli_query($con, $query);
    $debts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $debts[] = $row;
    }
    return $debts;
}

function addNewDebt($userID, $debtName, $payeeName, $debtDate, $maxPayDate, $principalAmount, $interestRate, $minimumPayment, $note) {
    $con = getConnection();
    $query = "INSERT INTO debt (user_id, debt_name, payee_name, total_amount, debt_date, max_pay_date, interest_rate, min_payment, notes) 
              VALUES ($userID, '$debtName', '$payeeName', $principalAmount, '$debtDate', '$maxPayDate', $interestRate, $minimumPayment, '$note')";
    return mysqli_query($con, $query);
}

function getDebtByID($debtID) {
    $con = getConnection();
    $query = "SELECT * FROM debt WHERE debt_id = $debtID LIMIT 1";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

function updateDebt($debtID, $debtName, $payeeName, $debtDate, $maxPayDate, $principalAmount, $interestRate, $minimumPayment, $note) {
    $con = getConnection();
    $query = "UPDATE debt SET 
              debt_name = '$debtName', 
              payee_name = '$payeeName', 
              total_amount = $principalAmount, 
              debt_date = '$debtDate', 
              max_pay_date = '$maxPayDate', 
              interest_rate = $interestRate, 
              min_payment = $minimumPayment, 
              notes = '$note' 
              WHERE debt_id = $debtID";
    return mysqli_query($con, $query);
}

function paymentDebt($debtID, $paymentAmount) {
    $con = getConnection();
    $query = "UPDATE debt SET paid_amount = paid_amount + $paymentAmount WHERE debt_id = $debtID";
    return mysqli_query($con, $query);
}

?>