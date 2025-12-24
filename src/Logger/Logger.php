<?php

namespace Monarch\SolidSolihin\Logger;

class Logger
{
    protected static $endpoint;
    protected static $projectCode;
    protected static $projectKey;
    protected static $debug = false;

    public static function init(array $config = [])
    {
        self::$endpoint    = $config['endpoint']    ?? getenv('SOLID_SOLIHIN_ENDPOINT');
        self::$projectCode = $config['project_code'] ?? getenv('SOLID_SOLIHIN_PROJECT_CODE');
        self::$projectKey  = $config['project_key']  ?? getenv('SOLID_SOLIHIN_PROJECT_KEY');
    }

    public static function setDebug(bool $value)
    {
        self::$debug = $value;
    }

    public static function info(string $message, array $context = [])
    {
        self::send('info', $message, $context);
    }

    public static function error(string $message, array $context = [])
    {
        self::send('error', $message, $context);
    }

    protected static function send(string $level, string $message, array $context = [])
    {
        $payload = [
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'environment' => getenv('CI_ENVIRONMENT') ?? getenv('APP_ENV') ?? 'production'
        ];

        $ch = curl_init(self::$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-project-code: ' . self::$projectCode,
            'x-project-key: '  . self::$projectKey
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 500); 

        $result = curl_exec($ch);
        $errno  = curl_errno($ch);
        $error  = curl_error($ch);
        curl_close($ch);

        if (self::$debug) {
            if ($errno) {
                error_log("[SolidSolihin] cURL error {$errno}: {$error}");
            } else {
                error_log("[SolidSolihin] Log sent: {$result}");
            }
        }
    }
}
