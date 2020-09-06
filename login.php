<?php

if (isset($_POST['family'])) {
    include "connect.php";

    $stmt = $conn->prepare("SELECT * FROM users WHERE secret=? LIMIT 1");
    $stmt->execute([$_POST['family']]);
    $user = $stmt->fetch();

    if (count($user) > 1) {
        ob_start();
        session_start();

        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['name'] = $user['name'];
        $_SESSION['picture'] = $user['picture'];
        $_SESSION['id'] = $user['id'];
        header("Location: status.php");

    } else {
        echo 'Wrong username or password';
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}