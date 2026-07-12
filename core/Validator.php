<?php

namespace Core;

class Validator
{
    public static function required($value): bool
    {
        return trim($value) !== '';
    }

    public static function email($value): bool
    {
        return filter_var(
            $value,
            FILTER_VALIDATE_EMAIL
        ) !== false;
    }

    public static function min(
        $value,
        int $length
    ): bool
    {
        return strlen($value) >= $length;
    }

    public static function max(
        $value,
        int $length
    ): bool
    {
        return strlen($value) <= $length;
    }

    public static function numeric($value): bool
    {
        return is_numeric($value);
    }
}