<?php

define("API_KEY", "HDEV-284f2d01-91dd-40a7-b52b-5ae7dbbe1309");
define("API_URL", "https://api.henrikdev.xyz/valorant/v1/stored-matches/eu/");

$NAME = "Plouf VoltaniX";
$TAG = "9168";

function get_request_json(string $name, string $tag): ?array
{
    $url_with_key = API_URL . rawurlencode($name) . "/" . rawurlencode($tag) . "?api_key=" . API_KEY;
    $curl_handle = curl_init();

    // Options cURL
    curl_setopt($curl_handle, CURLOPT_URL, $url_with_key);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'

    ));

    // Exécution de la requête
    $response = curl_exec($curl_handle);

    // Vérification des erreurs
    if (curl_errno($curl_handle)) {
        return null;
    }

    curl_close($curl_handle);
    $data = json_decode($response, true);
    return $data;
}
