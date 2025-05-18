<?php

$host = '127.0.0.1';
$dbname = 'moneymap';
$dbuser = 'root';
$dbpass = '';

function getConnection() {
    global $host, $dbname, $dbuser, $dbpass;

    mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

    try {
        $con = new mysqli($host, $dbuser, $dbpass, $dbname);
        return $con;
    } catch (mysqli_sql_exception $e) {
        echo "<div style='color: red; font-size: 18px; text-align: center; margin-top: 20px;'>
                <strong>Error:</strong> Connection failed to database. Please try later!
              </div>";
        exit();
    }
}

$con = getConnection();
?>
