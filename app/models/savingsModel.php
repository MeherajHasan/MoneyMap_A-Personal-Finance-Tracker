<?php
require_once('db.php');

function getTotalSavings($userID)
{
    $con = getConnection();
    $sql = "SELECT SUM(saved_amount) AS total FROM savings WHERE user_id = '$userID' AND (status = 1 OR STATUS = 2)"; // 0=deleted, 1=active, 2=achieved
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

function getTotalGoals($userID)
{
    $con = getConnection();
    $sql = "SELECT COUNT(*) AS total_goals FROM savings WHERE user_id = '$userID' AND (status = 1 OR status = 2)";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['total_goals'];
}

function getAchievedGoals($userID)
{
    $con = getConnection();
    $sql = "SELECT COUNT(*) AS achieved_goals FROM savings WHERE user_id = '$userID' AND status = 2";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result)['achieved_goals'];
}

function getAllSavingsDetails($userID)
{
    $con = getConnection();
    $sql = "SELECT * FROM savings WHERE user_id = '$userID' AND (status = 1 OR status = 2) ORDER BY target_date ASC";
    $result = mysqli_query($con, $sql);
    $savings = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $savings[] = $row;
    }

    return $savings;
}

function getSavingsById($id)
{
    $con = getConnection();
    $sql = "SELECT * FROM savings WHERE savings_id = '$id' LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    return null;
}

function updateSavings($id, $userId, $goalName, $targetAmount, $targetDate, $savedAmount, $notes)
{
    $con = getConnection();

    $sql = "UPDATE savings 
            SET goal_name = '$goalName',
                target_amount = '$targetAmount',
                target_date = '$targetDate',
                saved_amount = '$savedAmount',
                note = '$notes'
            WHERE savings_id = '$id' AND user_id = '$userId'";

    return mysqli_query($con, $sql);
} 

function addSavings($userId, $goalName, $targetAmount, $targetDate, $notes)
{
    $con = getConnection();
    $savedAmount = 0;

    $sql = "INSERT INTO savings (user_id, goal_name, target_amount, target_date, saved_amount, note) 
            VALUES ('$userId', '$goalName', '$targetAmount', '$targetDate', '$savedAmount', '$notes')";

    return mysqli_query($con, $sql);
}

function deleteSavings($id)
{
    $con = getConnection();
    $sql = "UPDATE savings SET status = 0 WHERE savings_id = '$id'";
    return mysqli_query($con, $sql);
}

function updateCompleteStatus($savingsID)
{
    $con = getConnection();
    
    $sql = "SELECT target_amount, saved_amount FROM savings WHERE savings_id = '$savingsID'";
    $result = mysqli_query($con, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        if ((float)$row['target_amount'] === (float)$row['saved_amount']) {
            $updateSql = "UPDATE savings SET status = 2 WHERE savings_id = '$savingsID'";
            $updateResult = mysqli_query($con, $updateSql);
            return $updateResult; 
        }
    }
    
    return false;
}
?>
