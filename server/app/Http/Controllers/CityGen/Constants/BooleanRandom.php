<?php

namespace App\Http\Controllers\CityGen\Constants;

use App\Http\Controllers\CityGen\Services\RandomCity\RandomService;

class BooleanRandom extends BaseEnum
{
    const RANDOM = RandomService::RANDOM;
    const TRUE = 'Yes';
    const FALSE = 'No';

    public static function construct($value)
    {
        return $value ? BooleanRandom::TRUE : BooleanRandom::FALSE;
    }
}
