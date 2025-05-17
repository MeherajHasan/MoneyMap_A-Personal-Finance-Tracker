<?php

mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

$host = '127.0.0.1';
$user = 'root';
$password = '';
$database = 'moneymap';

try {
    $con = new mysqli($host, $user, $password, $database);
} 
catch (mysqli_sql_exception $e) {
    echo "<div style='color: red; font-size: 18px; text-align: center; margin-top: 20px;'>
            <strong>Error:</strong> Connection failed to database. Please try later!
          </div>";
    exit();
}
