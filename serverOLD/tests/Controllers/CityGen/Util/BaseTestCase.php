<?php

namespace Test\Controllers\CityGen\Util;

use App\Http\Controllers\ILoveAustin\Services\ServicesService;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /** @var ServicesService */
    protected $services;

    public function __construct()
    {
        parent::__construct();
        $this->services = new TestServicesService();
    }

    protected function assertIsSorted($array, $getSortValueCallback)
    {
        $values = array_map(function ($object) use($getSortValueCallback) { return $getSortValueCallback($object); }, $array);
        $isSorted = array_reduce($values, function ($carry, $value) {
            if ($carry !== null) {
                // strings must be string sorted
                if (((($carry !== null && is_string($carry)) || ($carry === null && is_string($value))) && strcmp($value, $carry) > 0) ||
                    // numbers must be number sorted
                    ((($carry !== null && !is_string($carry)) || ($carry === null && !is_string($value))) && $value > $carry)
                ) {
                    $carry = $value;
                } else {
                    $carry = null;
                }
            }
            return $carry;
        }, '');
        $this->assertNotNull($isSorted);
    }
}
