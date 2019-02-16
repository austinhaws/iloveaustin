<?php

namespace App\Http\Controllers\ILoveAustin\Constants;

use ReflectionClass;
use RuntimeException;

abstract class BaseEnum
{
    /**
     * @return array
     */
    public static function getConstants()
    {
        try {
            return (new ReflectionClass(get_called_class()))->getConstants();
        } catch (\ReflectionException $e) {
            throw new RuntimeException($e);
        }
    }
}
