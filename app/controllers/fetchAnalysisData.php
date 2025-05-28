<?php
header('Content-Type: application/json');

require_once(__DIR__ . '/userAuth.php');
require_once(__DIR__ . '/../models/analysisModel.php');

$userId = $_SESSION['user']['id'];

$data = [
    'total_income' => totalIncome($userId),
    'total_expense' => totalExpense($userId),
    'total_budget' => totalBudget($userId),
    'total_spent' => totalSpent($userId),
    'net_balance' => totalIncome($userId) - totalExpense($userId),
    'debt_paid' => totalDebtPaid($userId),
    'debt_payable' => totalDebt($userId) - totalDebtPaid($userId),
    'savings' => totalSavings($userId),
    'savings_goal' => totalSavingsGoal($userId),
    'monthly_income' => monthlyIncome($userId),
    'monthly_expense' => monthlyExpenses($userId)
];

echo json_encode($data);
exit;
