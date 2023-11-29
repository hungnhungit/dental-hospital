<?php

namespace App\Helpers;

use App\Models\BenhNhan;
use Illuminate\Support\Str;

class Helper
{
    public static function genCode()
    {
        $currentDate = now();
        $count = BenhNhan::query()->whereRaw("SUBSTRING(Ma, 1, 4) = DATE_FORMAT(now(), '%y%m')")->count();
        return sprintf('%d%d-%s', $currentDate->format('y'), $currentDate->month, Str::padLeft($count + 1, 3, '0'));
    }
}
