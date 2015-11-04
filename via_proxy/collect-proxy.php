<?php

$headers = getallheaders();
$payload = array();
$endpoint = 'http://www.google-analytics.com/collect';

foreach ($headers as $header_name => $header_value) {
  if(substr($header_name, 0, 6) == 'X-Amp-') {
    $payload_key = strtolower(substr($header_name, 6));
    if($header_name == 'X-Amp-Cid') {
      $payload_value = substr($header_value, 4);
    } else {
      $payload_value = $header_value;
    }
    $payload[$payload_key] = $payload_value;
  }
}

//error_log(json_encode($payload));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec ($ch);
curl_close ($ch);

//error_log($response);
