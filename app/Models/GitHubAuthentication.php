<?php

namespace App\Models;

class GitHubAuthentication extends HttpClient
{
    const URL = 'https://github.com/login/oauth';

    public static function getAuthorizeUrl()
    {
        return self::URL . '/authorize' . '?client_id=' . env('OAUTH_CLIENT_ID') . '&scope=repo&allow_signup=false';
    }

    public static function sendRequestPost($data = [])
    {
        $url = self::URL . '/access_token';

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'scope' => 'repo'
        ];
        $response = static::sendRequest($url, 'POST', $headers, $data);
        $responseBody = json_decode($response, true);

        return $responseBody;
    }

    public static function getToken($code)
    {
        $res = static::sendRequestPost([
            'client_id' => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_SECRET'),
            'code' => $code
        ]);

        return $res['access_token'];
    }


}
