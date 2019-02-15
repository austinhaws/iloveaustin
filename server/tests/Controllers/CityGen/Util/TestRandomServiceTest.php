<?php

namespace App\Http\Controllers\CityGen\Util;

use Test\Controllers\CityGen\Util\BaseTestCase;

class TestRandomServiceTest extends BaseTestCase
{
    public function testRandMax()
    {
        // if randmax changes then it will change the test result of randRatio
        $this->assertSame(RollRatio::RAND_MAX, getrandmax());
    }
}
