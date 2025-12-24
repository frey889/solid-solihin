<?php

namespace Monarch\SolidSolihin\Logger;

use Monarch\SolidSolihin\Transport\SupabaseTransport;
use Monarch\SolidSolihin\Support\Env;
use Monarch\SolidSolihin\Support\Debug;

class Logger
{
    protected static function basePayload(
        string $level,
        string $message,
        array $context = []
    ): array {
        return [
            'project_code' => Env::get('SOLID_SOLIHIN_PROJECT_CODE'),
            'project_key'  => Env::get('SOLID_SOLIHIN_PROJECT_KEY'),
            'environment'  => Env::get('CI_ENVIRONMENT', 'production'),
            'level'        => $level,
            'message'      => $message,
            'context'      => $context,
            'timestamp'    => date('c'),
        ];
    }

    protected static function dispatch(array $payload): void
    {
        if (empty($payload['project_code']) || empty($payload['project_key'])) {
            Debug::log('Missing project credentials', $payload);
            return;
        }

        // async-ish: fire and forget
        register_shutdown_function(function () use ($payload) {
            SupabaseTransport::send($payload);
        });
    }

    public static function info(string $message, array $context = []): void
    {
        self::dispatch(self::basePayload('info', $message, $context));
    }

    public static function error(string $message, array $context = []): void
    {
        self::dispatch(self::basePayload('error', $message, $context));
    }

    public static function exception(\Throwable $e, array $context = []): void
    {
        self::dispatch(array_merge(
            self::basePayload('exception', $e->getMessage(), $context),
            [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]
        ));
    }
}
