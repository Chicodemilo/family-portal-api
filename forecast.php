<?php
//test4
use Carbon\Carbon;

require __DIR__ . '/bootstrap.php';

$url = "https://api.weatherbit.io/v2.0/forecast/daily?city=Austin,TX&units=I&days=7&key=" . $wBitKey;

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
$forecastDays = [];
if (!isset($currentWeather->data)) {
    $forecastDays[] = [
        'day' => 'Flarg',
        'high' => 42,
        'low' => 42,
        'description' => 'Tacos',
        'icon' => '/family-portal-api/images/bug-solid.svg',
    ];
} else {

    foreach ($currentWeather->data as $dailyWeather) {
        $dayString = new Carbon($dailyWeather->valid_date);

        $daySmall = $dayString->format("D");

        $iconurl = "https://www.weatherbit.io/static/img/icons/" . $dailyWeather->weather->icon . ".png";
        $forecastDays[] = [
            'day' => $daySmall,
            'high' => round($dailyWeather->high_temp, 0),
            'low' => round($dailyWeather->min_temp, 0),
            'description' => $dailyWeather->weather->description,
            'icon' => $iconurl,
        ];
    }
}

echo json_encode($forecastDays);