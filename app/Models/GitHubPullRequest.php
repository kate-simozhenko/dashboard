<?php

namespace App\Models;

use GuzzleHttp\RequestOptions;

class GitHubPullRequest extends HttpClient
{
    const API = 'https://api.github.com';

    public static function sendRequestGet($url, $data = [], $token = '')
    {
        $url = self::API. '/' . $url;
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        if ($token) $headers['Authorization'] = 'token ' . $token;

        $response = static::sendRequest($url, 'GET', $headers, $data);
        $responseBody = json_decode($response, true);

        return $responseBody;
    }

    public static function sendRequestPatch($url, $data = [], $token = '')
    {
        $apiUrl = self::API. '/' . $url;
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/vnd.github.v3+json',
            'Authorization' => 'token ' . $token
        ];
        $response = static::sendRequest($apiUrl, 'PATCH', $headers, $data);
        $responseBody = json_decode($response, true);

        return $responseBody;
    }
}
