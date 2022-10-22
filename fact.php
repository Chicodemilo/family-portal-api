<?php
require __DIR__ . '/bootstrap.php';
$curl = curl_init();
//test8888

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://uselessfacts.jsph.pl/random.json?language=en",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_COOKIE => "__cfduid=d8365eaec370c1c67d169886c31755ae21581879322",
    CURLOPT_HTTPHEADER => array(
        "accept: application/json",
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $factData = json_decode($response);
}
$find = [
    "sex",
    "vagina",
    "orgasm",
    "penis",
    "dildo",
    "masterbation",
    "masterbate",
    "Sex",
    "Vagina",
    "Orgasm",
    "Penis",
    "Dildo",
    "Masterbation",
    "Masterbate",
];
$replace = [
    "whoopie",
    "hoo-hoo",
    "bazinga",
    "wee-wee",
    "chachi",
    "silly-time",
    "wash the eggplant",
    "Whoopie",
    "Cha-Cha",
    "Woo-Hoo",
    "Bing-Bong",
    "Meow",
    "Bowling",
    "Cook lasagna",
];

$fact = [
    'fact' => str_replace($find, $replace, $factData->text),
];

echo json_encode($fact);