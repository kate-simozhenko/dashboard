<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class HttpClient
{
    private static $client;

    private static function getClient()
    {
        if (null === static::$client) {
            static::$client = new Client();
        }

        return static::$client;
    }

    public static function sendRequest($url, $method, $headers = [], $data = [])
    {
        $client = static::getClient();

        try {
            $response = $client->request($method, $url, [
                'headers' => $headers,
                RequestOptions::JSON => $data
            ]);

            $responseBody = $response->getBody()->getContents();
            return $responseBody;
        } catch (\Exception $ex) {
            return $ex->getResponse()->getBody()->getContents();
        }
    }
}
