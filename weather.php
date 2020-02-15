<?php

require __DIR__ . '/bootstrap.php';

// use Dotenv\Dotenv;

// $httpStatus = 200;
// header('Access-Control-Allow-Origin: http://localhost:3000');
// header('Content-type:application/json;charset=utf-8');
// header('Status: ' . $httpStatus);

// $dotenv = Dotenv::createImmutable(__DIR__);
// $dotenv->load();
// $wBitKey = $_ENV['WEATHERBIT_KEY'];

$url = "https://api.weatherbit.io/v2.0/current?postal_code=78757&units=I&key=" . $wBitKey;

$options = array(
    CURLOPT_HEADER => false,
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false
);

$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);

$currentWeather = json_decode($json);

foreach ($currentWeather->data as $weather) {
    $iconurl = "https://www.weatherbit.io/static/img/icons/" . $weather->weather->icon . ".png";
    $current = [
        'sunset' => $weather->sunset,
        'precip' => $weather->precip,
        'sunrise' => $weather->sunrise,
        'temp' => $weather->temp,
        'wind_spd' => $weather->wind_spd,
        'wind_cdir_full' => $weather->wind_cdir_full,
        'description' => $weather->weather->description,
        'icon' => $iconurl,
    ];
}

echo json_encode($current);
