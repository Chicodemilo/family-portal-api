<?php
require __DIR__ . '/bootstrap.php';

use Carbon\Carbon;

function buildBaseString($baseURI, $method, $params)
{
    $r = array();
    ksort($params);
    foreach ($params as $key => $value) {
        $r[] = "$key=" . rawurlencode($value);
    }
    return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function buildAuthorizationHeader($oauth)
{
    $r = 'Authorization: OAuth ';
    $values = array();
    foreach ($oauth as $key => $value)
        $values[] = "$key=\"" . rawurlencode($value) . "\"";
    $r .= implode(', ', $values);
    return $r;
}

$url = "https://api.twitter.com/1.1/search/tweets.json";

$oauth = array(
    'q' => 'QZZXXWEE42',
    'count' => 5,
    'oauth_consumer_key' => $consumer_key,
    'oauth_nonce' => time(),
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_token' => $oauth_access_token,
    'oauth_timestamp' => time(),
    'oauth_version' => '1.0'
);

$base_info = buildBaseString($url, 'GET', $oauth);
// var_dump($base_info);
// die();
$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;


$header = array(buildAuthorizationHeader($oauth), 'Expect:');
$options = array(
    CURLOPT_HTTPHEADER => $header,
    CURLOPT_HEADER => false,
    CURLOPT_URL => $url . '?q=QZZXXWEE42&count=5',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false
);

$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);

$twitter_data = json_decode($json);

$tweets = [];

foreach ($twitter_data->statuses as $tweet) {
    $formatDate = new Carbon($tweet->created_at);
    $formatDate->setTimezone('America/Chicago');
    $aWeekAgo = new Carbon();
    // var_dump($aWeekAgo->setTimezone('America/Chicago')->subWeek(1));
    if ($formatDate > $aWeekAgo->setTimezone('America/Chicago')->subWeek(1)) {
        $tweets[] = ['summary' => $tweet->text, 'date' => $formatDate->format('n/j/y g:ia')];
    }
}

echo json_encode($tweets);
