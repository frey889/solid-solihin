<?php

namespace Monarch\SolidSolihin\Support;

class Debug
{
    public static function enabled(): bool
    {
        return Env::bool('SOLID_SOLIHIN_DEBUG', false);
    }

    public static function log(string $message, array $context = []): void
    {
        if (!self::enabled()) return;

        $line = date('Y-m-d H:i:s')
            . ' [SolidSolihin] '
            . $message;

        if (!empty($context)) {
            $line .= ' ' . json_encode($context);
        }

        $line .= PHP_EOL;

        // ke file
        file_put_contents(
            __DIR__ . '/../../solid-solihin.debug.log',
            $line,
            FILE_APPEND
        );
    }

}
