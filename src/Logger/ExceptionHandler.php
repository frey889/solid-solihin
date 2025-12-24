<?php

namespace Monarch\SolidSolihin\Logger;

class ExceptionHandler
{
    public static function register()
    {
        set_exception_handler(function($e) {
            Logger::error('Unhandled Exception', [
                'exception' => $e->getMessage(),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'trace'     => $e->getTraceAsString()
            ]);

            throw $e;
        });
    }
}
