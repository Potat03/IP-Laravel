<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WebPurifyService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = '1908578d279e0530c81f0014a270088a'; // Api key
    }

    public function checkProfanity($text)
    {
        $response = Http::get('https://api1.webpurify.com/services/rest/', [
            'method' => 'webpurify.live.check',
            'api_key' => $this->apiKey,
            'text' => $text,
            'format' => 'json',
        ]);

        $body = $response->json();
        return $body['rsp']['found'] ?? 0;
    }
}
