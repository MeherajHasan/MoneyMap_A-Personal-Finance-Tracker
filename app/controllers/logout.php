<?php
session_start();
session_unset();
session_destroy();

setcookie('remember_email', '', time() - 3600, '/');
setcookie('remember_password', '', time() - 3600, '/');

header("Location: ../../public/index.php");
exit();
?>
