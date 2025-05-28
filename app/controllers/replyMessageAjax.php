<?php
require_once('../models/contactModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageID = $_POST['messageID'];

    if (replyMessage($messageID)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database update failed']);
    }
}
?>
