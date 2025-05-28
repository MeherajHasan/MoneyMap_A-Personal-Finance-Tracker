<?php
header('Content-Type: application/json');

require_once(__DIR__ . '/userAuth.php');
require_once(__DIR__ . '/../models/incomeModel.php');

$userID = $_SESSION['user']['id'];

$input = json_decode(file_get_contents('php://input'), true);

$yearFilter = isset($input['year']) ? $input['year'] : null;

$data = getMonthlyIncomeByType($userID, $yearFilter);

echo json_encode($data);
exit;
?>
