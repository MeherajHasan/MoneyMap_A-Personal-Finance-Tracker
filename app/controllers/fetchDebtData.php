<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/userAuth.php');
require_once(__DIR__ . '/../models/debtModel.php');

$userID = $_SESSION['user']['id'];
$data = getDebtDataByUser($userID);

echo json_encode($data);
exit;
?>