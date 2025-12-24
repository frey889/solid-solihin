<?php

namespace Monarch\SolidSolihin\Client;

class AsyncHttpClient
{
    public static function post(string $url, array $payload): void
    {
        if (!$url) {
            return;
        }

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST               => true,
            CURLOPT_HTTPHEADER         => [
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS         => json_encode($payload),
            CURLOPT_RETURNTRANSFER     => false,
            CURLOPT_TIMEOUT_MS         => 300,
            CURLOPT_CONNECTTIMEOUT_MS  => 300,
            CURLOPT_NOSIGNAL           => true,
            CURLOPT_FORBID_REUSE       => true,
        ]);

        // fire & forget
        curl_exec($ch);
        curl_close($ch);
    }
}
