<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function format(string $date, string $format = 'd M Y'): string
    {
        return Carbon::parse($date)->format($format);
    }
}
