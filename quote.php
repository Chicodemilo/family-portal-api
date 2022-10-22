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

if (isset($quoteData->error) || !isset($quoteData->contents->quotes[0]->quote) || $rando == 2) {

    $pick = rand(1, 6);
    $quote1 = [
        'quote' => 'I’ve missed more than 9,000 shots in my career. I’ve lost almost 300 games. Twenty-six times I’ve been trusted to take the game-winning shot and missed. I’ve failed over and over and over again in my life. And that is why I succeed.',
        'author' => 'Michael Jordan',
    ];
    $quote2 = [
        'quote' => 'Just believe in yourself. Even if you don’t, pretend that you do. Then at some point, you will',
        'author' => 'Venus Williams',
    ];

    $quote3 = [
        'quote' => 'Most people give up just when they’re about to achieve success. They quit on the one yard line. They give up at the last minute of the game one foot from a winning touchdown.',
        'author' => 'Ross Perot',
    ];

    $quote4 = [
        'quote' => 'I’ve learned that something constructive comes from every defeat.',
        'author' => 'Tom Landry',
    ];

    $quote5 = [
        'quote' => 'If you\'re going through hell, keep going.',
        'author' => 'Winston Churchill',
    ];

    $quote6 = [
        'quote' => 'You have enemies? Good. That means you\'ve stood up for something, sometime in your life.',
        'author' => 'Winston Churchill',
    ];

    switch ($pick) {
        case 1:
            $quote = $quote1;
            break;
        case 2:
            $quote = $quote2;
            break;
        case 3:
            $quote = $quote3;
            break;
        case 4:
            $quote = $quote4;
            break;
        case 5:
            $quote = $quote5;
            break;
        case 6:
            $quote = $quote6;
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