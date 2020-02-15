<?php
$httpStatus = 200;
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-type:application/json;charset=utf-8');
header('Status: ' . $httpStatus);

echo json_encode(["test" => "TEST"]);
