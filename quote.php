<?php

require __DIR__ . '/bootstrap.php';

$curl = curl_init();

$categories = ['inspire', 'sports', 'funny', 'inspire'];
$which = rand(0, 3);

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://quotes.rest/qod.json?category=" . $categories[$which],
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
    $quoteData = json_decode($response);
}

$rando = rand(1, 2);

if (isset($quoteData->error) || $rando == 2) {

    $pick = rand(1, 2);
    $quote1 = [
        'quote' => 'I’ve missed more than 9,000 shots in my career. I’ve lost almost 300 games. Twenty-six times I’ve been trusted to take the game-winning shot and missed. I’ve failed over and over and over again in my life. And that is why I succeed.',
        'author' => 'Michael Jordan',
    ];
    $quote2 = [
        'quote' => 'Just believe in yourself. Even if you don’t, pretend that you do. Then at some point, you will',
        'author' => 'Venus Williams',
    ];

    switch ($pick) {
        case 1:
            $quote = $quote1;
            break;
        case 2:
            $quote = $quote2;
            break;
        default:
            $quote = $quote1;
            break;
    }

} else {
    $quote = [
        'quote' => $quoteData->contents->quotes[0]->quote,
        'author' => $quoteData->contents->quotes[0]->author,
    ];
}

echo json_encode($quote);