<?php

namespace Monarch\SolidSolihin\Transport;

use Monarch\SolidSolihin\Support\Env;
use Monarch\SolidSolihin\Support\Debug;

class SupabaseTransport
{
    public static function send(array $payload): void
    {
        $endpoint = rtrim(
            Env::get('SOLID_SOLIHIN_ENDPOINT'),
            '/'
        ) . '/functions/v1/log-ingest';

        if (!$endpoint) {
            Debug::log('Missing SOLID_SOLIHIN_ENDPOINT');
            return;
        }

        $ch = curl_init($endpoint);

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,

            // TIMEOUT LEBIH MANUSIAWI
            CURLOPT_CONNECTTIMEOUT => 2, // detik
            CURLOPT_TIMEOUT => 3,        // detik

            // penting di windows
            CURLOPT_SSL_VERIFYPEER => true,
        ]);


        $response = curl_exec($ch);
        $errno    = curl_errno($ch);
        $error    = curl_error($ch);
        $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($errno) {
            Debug::log('cURL error', [
                'errno' => $errno,
                'error' => $error
            ]);
            return;
        }

        if ($status >= 400) {
            Debug::log('Supabase rejected log', [
                'status' => $status,
                'response' => $response
            ]);
        }
    }
}
