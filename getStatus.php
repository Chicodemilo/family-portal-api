<?php
include 'bootstrap.php';
include 'connect.php';

$stmt = $conn->query("SELECT u.id, u.name FROM users as u");
$users = $stmt->fetchAll();

foreach ($users as $key => $user) {
    $stmt2 = $conn->prepare("SELECT status, created_at FROM status WHERE user_id=? ORDER BY created_at DESC LIMIT 1");
    $stmt2->execute([$user['id']]);
    $status = $stmt2->fetch();
    if ($status) {
        $users[$key]['status']['created_at'] = $status['created_at'];
        $users[$key]['status']['text'] = $status['status'];
    } else {
        $users[$key]['status']['created_at'] = '';
        $users[$key]['status']['text'] = '';
    }
}

echo json_encode($users);