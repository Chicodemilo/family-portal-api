<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Carbon\Carbon;

$httpStatus = 200;
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-type:application/json;charset=utf-8');
header('Status: ' . $httpStatus);

$carbon = new Carbon();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$oauth_access_token = $_ENV['OAUTH_ACCESS_TOKEN'];
$oauth_access_token_secret = $_ENV['OAUTH_ACCESS_TOKEN_SECRET'];
$consumer_key = $_ENV['CONSUMER_KEY'];
$consumer_secret = $_ENV['CONSUMER_SECRET'];
$wBitKey = $_ENV['WEATHERBIT_KEY'];
$wBitKey = $_ENV['WEATHERBIT_KEY'];
$calendarId = $_ENV['CALENDAR_ID'];
