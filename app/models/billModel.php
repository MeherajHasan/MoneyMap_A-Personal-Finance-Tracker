<?php
require_once 'db.php';
require_once 'expenseCategoryModel.php';
require_once 'expenseModel.php';

function getAllBills($userId)
{
    $con = getConnection();
    $query = "SELECT * FROM bills WHERE user_id = $userId ORDER BY payment_date DESC";
    $result = mysqli_query($con, $query);
    $bills = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $bills[] = $row;
    }

    return $bills;
}

function addBill($userId, $billName, $amount, $paymentDate, $status)
{
    $con = getConnection();
    $expenseId = addExpenseReturnId($userId, 3, $billName, $amount, $paymentDate);

    if ($expenseId) {
        $sql = "INSERT INTO bills (user_id, expense_id, category_id, bill_name, amount, payment_date, status)
                VALUES ('$userId', '$expenseId', 3, '$billName', '$amount', '$paymentDate', '$status')";
        return mysqli_query($con, $sql);
    }
}

function addBillViaExpense($userId, $expenseID, $billName, $amount, $paymentDate, $status) {
    $con = getConnection();
    $sql = "INSERT INTO bills (user_id, expense_id, category_id, bill_name, amount, payment_date, status)
            VALUES ('$userId', '$expenseID', 3, '$billName', '$amount', '$paymentDate', '$status')";
    return mysqli_query($con, $sql);
}

function countPaidBills($userId)
{
    $con = getConnection();
    $query = "SELECT COUNT(*) AS count FROM bills WHERE user_id = $userId AND status = 0";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function countDueBills($userId)
{
    $con = getConnection();
    $query = "SELECT COUNT(*) AS count FROM bills WHERE user_id = $userId AND status = 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

function getBillById($billId)
{
    $con = getConnection();
    $sql = "SELECT * FROM bills WHERE bill_id = '$billId'";
    $result = mysqli_query($con, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
}

function updateBill($id, $userId, $billName, $amount, $dueDate, $status, $expenseID, $note)
{
    $con = getConnection();
    $category_id = 3;
    $updateExpense = updateExpense($expenseID, $category_id, $billName, $amount, $note, $dueDate);
    if ($updateExpense) {
        $query = "UPDATE bills SET bill_name = '$billName', amount = $amount, payment_date = '$dueDate', status = $status 
                  WHERE bill_id = $id AND user_id = $userId";
        return mysqli_query($con, $query);
    }
}

function deleteBill($billID, $expenseID)
{
    $con = getConnection();

    $deleteFromExpense = deleteExpense($expenseID);
    if ($deleteFromExpense) {
        $sql = "DELETE FROM bills WHERE bill_id = '$billID'";
        return mysqli_query($con, $sql);
    }
}

function totalBillAmount($userId)
{
    $con = getConnection();
    $query = "SELECT SUM(amount) AS total FROM bills WHERE user_id = $userId";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getAllUserTotalBills() {
    $con = getConnection();
    $sql = "SELECT SUM(amount) AS total_bill FROM bills";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_bill'];
    } 
}
?>
