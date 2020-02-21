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
        "accept: application/json"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $quoteData = json_decode($response);
    var_dump($quoteData->contents->quotes[0]->quote);
    var_dump($quoteData->contents->quotes[0]->author);
}

$quote = [
    'quote' => $quoteData->result->quote,
    'author' => $quoteData->result->author,
];

echo json_encode($quote);
