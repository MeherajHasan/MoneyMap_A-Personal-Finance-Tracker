<?php
require_once('db.php'); 

function createContactMessage($userID, $fullName, $email, $subject, $message) {
    $con = getConnection();
    $userID = $userID !== null ? $userID : 'NULL';
    $query = "INSERT INTO contact_messages (user_id, full_name, email, subject, message) 
              VALUES ($userID, '$fullName', '$email', '$subject', '$message')";
    $result = mysqli_query($con, $query);
    return $result;
}

function getNewMessagesFromUsers() {
    $con = getConnection();
    $query = "SELECT * FROM contact_messages WHERE status = 0 AND user_id IS NOT NULL ORDER BY created_at DESC";
    $result = mysqli_query($con, $query);
    return $result;
}

function getRepliedMessagesFromUsers() {
    $con = getConnection();
    $query = "SELECT * FROM contact_messages WHERE status = 1 AND user_id IS NOT NULL ORDER BY created_at DESC";
    $result = mysqli_query($con, $query);
    return $result;
}

function getNewMessagesFromVisitors() {
    $con = getConnection();
    $query = "SELECT * FROM contact_messages WHERE status = 0 AND user_id IS NULL ORDER BY created_at DESC";
    $result = mysqli_query($con, $query);
    return $result;
}

function getRepliedMessagesFromVisitors() {
    $con = getConnection();
    $query = "SELECT * FROM contact_messages WHERE status = 1 AND user_id IS NULL ORDER BY created_at DESC";
    $result = mysqli_query($con, $query);
    return $result;
}

function deleteContactMessage($messageID) {
    $con = getConnection();
    $query = "UPDATE contact_messages SET status = 2 WHERE id = $messageID";
    $result = mysqli_query($con, $query);
    return $result;
}

function replyMessage($messageID) {
    $con = getConnection();
    $query = "UPDATE contact_messages SET status = 1 WHERE id = $messageID";
    $result = mysqli_query($con, $query);
    return $result;
}
?>