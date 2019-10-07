<?php

namespace App\Http\Controllers\ILoveAustin\Constants;

use App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomService;

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
