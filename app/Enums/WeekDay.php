<?php

namespace App\Enums;

enum WeekDay: string
{
    case SATURDAY = 'Saturday';
    case SUNDAY = 'Sunday';
    case MONDAY = 'Monday';
    case TUESDAY = 'Tuesday';
    case WEDNESDAY = 'Wednesday';
    case THURSDAY = 'Thursday';
    case FRIDAY = 'Friday';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}