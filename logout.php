<?php
session_start();

$_SESSION['valid'] = false;
unset($_SESSION["name"]);
unset($_SESSION["picture"]);
unset($_SESSION["id"]);

echo 'Bye!';
header('Refresh: 1; URL = index.php');