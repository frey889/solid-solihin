<?php

namespace Monarch\SolidSolihin\Support;

class Env
{
    public static function get(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);

        if ($value === false || $value === '') {
            return $default;
        }

        return $value;
    }
}
