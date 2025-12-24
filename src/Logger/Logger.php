<?php

namespace Monarch\SolidSolihin\Logger;

use Throwable;
use Monarch\SolidSolihin\Client\AsyncHttpClient;
use Monarch\SolidSolihin\Support\Env;

class Logger
{
    protected static function basePayload(): array
    {
        return [
            'project_code' => Env::get('SOLID_SOLIHIN_PROJECT_CODE'),
            'project_key'  => Env::get('SOLID_SOLIHIN_PROJECT_KEY'),
            'environment'  => Env::get('SOLID_SOLIHIN_ENV', 'production'),
            'ip_address'   => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent'   => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'request_id'   => $_SERVER['HTTP_X_REQUEST_ID'] ?? null,
            'timestamp'    => date('c')
        ];
    }

    protected static function endpoint(): ?string
    {
        return Env::get('SOLID_SOLIHIN_ENDPOINT');
    }

    public static function error(Throwable $e, array $context = []): void
    {
        AsyncHttpClient::post(
            self::endpoint(),
            array_merge(self::basePayload(), [
                'level'     => 'error',
                'message'   => $e->getMessage(),
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'trace'     => $e->getTraceAsString(),
                'context'   => $context
            ])
        );
    }

    public static function warning(string $message, array $context = []): void
    {
        AsyncHttpClient::post(
            self::endpoint(),
            array_merge(self::basePayload(), [
                'level'   => 'warning',
                'message' => $message,
                'context' => $context
            ])
        );
    }

    public static function info(string $message, array $context = []): void
    {
        AsyncHttpClient::post(
            self::endpoint(),
            array_merge(self::basePayload(), [
                'level'   => 'info',
                'message' => $message,
                'context' => $context
            ])
        );
    }
}
