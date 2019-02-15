<?php

namespace App\Http\Controllers\CityGen\Util;

class RollRatio
{
    const RAND_MAX = 2147483647;

    /**
     * rand ratio is based on dividing rand max by a rand value
     * for testing, to make this repeatable, this function gets
     * a ratioed value from the maximum
     *
     * @param float $percent
     * @return float|int
     */
    public static function ratioPercent(float $percent)
    {
        return ($percent / 100.0) * RollRatio::RAND_MAX;
    }
}
