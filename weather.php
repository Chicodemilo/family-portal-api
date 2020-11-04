<?php

require __DIR__ . '/bootstrap.php';

use Carbon\Carbon;
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
    CURLOPT_SSL_VERIFYPEER => false,
);

$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);

$currentWeather = json_decode($json);

foreach ($currentWeather->data as $weather) {
    $formatSunset = new Carbon($weather->sunset);
    $formatSunrise = new Carbon($weather->sunrise);

    if (date('I') == 0) {
        $timeSub = 6;
    } else {
        $timeSub = 5;
    }

    $iconurl = "https://www.weatherbit.io/static/img/icons/" . $weather->weather->icon . ".png";
    $current = [
        'sunset' => $formatSunset->subHours($timeSub)->format('g:ia'),
        'precip' => $weather->precip,
        'sunrise' => $formatSunrise->subHours($timeSub)->format('g:ia'),
        'temp' => $weather->temp,
        'wind_spd' => $weather->wind_spd,
        'wind_cdir_full' => $weather->wind_cdir_full,
        'description' => $weather->weather->description,
        'icon' => $iconurl,
    ];
}

echo json_encode($current);