<?php

require_once('db.php');

function login($user) {
    $con = getConnection();
    // Note: This example uses raw query — ideally use prepared statements to avoid SQL injection.
    $sql = "SELECT * FROM users WHERE email = '{$user['email']}' AND password = '{$user['password']}'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);  // return full user row as associative array
    } else {
        return false;
    }
}
?>
