<?php

namespace Monarch\SolidSolihin\Support;

class Env
{
    public static function get(string $key, $default = null)
    {
        return $_ENV[$key]
            ?? getenv($key)
            ?? $default;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $val = self::get($key);
        if ($val === null) return $default;
        return in_array(strtolower($val), ['1','true','yes','on'], true);
    }
}
