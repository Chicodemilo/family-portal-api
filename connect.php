<?php
include 'bootstrap.php';
$servername = "localhost";
$username = "fambo";
$password = $db_secret;

try {
    $conn = new PDO("mysql:host=$servername;dbname=portal", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}