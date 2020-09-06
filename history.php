<?php
require __DIR__ . '/bootstrap.php';
include './historyUtilities.php';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://history.muffinlabs.com/date",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $historyData = (array) json_decode($response, true);
}

$historyUtilities = new HistoryUtilities($historyData);

$history = [
    'history' => $historyUtilities->text,
];

echo json_encode($history);