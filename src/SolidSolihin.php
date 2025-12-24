<?php

namespace Monarch\SolidSolihin;

use Monarch\SolidSolihin\Logger\Logger;
use Throwable;

class SolidSolihin
{
    public static function registerGlobalHandlers(): void
    {
        set_exception_handler(function (Throwable $e) {
            Logger::error($e);
        });

        set_error_handler(function ($severity, $message, $file, $line) {
            Logger::warning($message, [
                'file'     => $file,
                'line'     => $line,
                'severity' => $severity
            ]);
        });
    }
}
