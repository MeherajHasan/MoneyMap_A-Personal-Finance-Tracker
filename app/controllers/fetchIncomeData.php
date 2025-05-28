<?php
header('Content-Type: application/json');

require_once(__DIR__ . '/userAuth.php');
require_once(__DIR__ . '/../models/incomeModel.php');

$userID = $_SESSION['user']['id'];
$data = getMonthlyIncomeByType($userID);

echo json_encode($data);
exit;
?>