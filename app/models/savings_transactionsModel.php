<?php
require_once('db.php');
require_once('savingsModel.php');

function addSavingsTransaction($savingsID, $amount, $transactionDate, $note)
{
    $con = getConnection();
    $sql1 = "INSERT INTO savings_transactions (savings_id, amount, transaction_date, note)
             VALUES ('$savingsID', '$amount', '$transactionDate', '$note')";
    $result1 = mysqli_query($con, $sql1);

    $sql2 = "UPDATE savings SET saved_amount = saved_amount + $amount WHERE savings_id = '$savingsID'";
    $result2 = mysqli_query($con, $sql2);

    return $result1 && $result2;
}
?>