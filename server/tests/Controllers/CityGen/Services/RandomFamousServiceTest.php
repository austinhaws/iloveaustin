<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomFamousServiceTest extends BaseTestCase
{

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomCommoditiesService::determineCommodities
     */
    public function testRandomCommodities()
    {
        $postData = new PostData();

        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;

        $this->services->random->setRolls([
            new TestRoll('Number Famous', 4, 2, 4),
            new TestRoll('FamousTable: range', 4, 1, 4250),
            new TestRoll('FamousTable: range', 5, 1, 4250),
            new TestRoll('FamousTable: range', 550, 1, 4250),
            new TestRoll('FamousTable: range', 4, 1, 4250),
            new TestRoll('FamousTable: range', 20, 1, 4250),
            new TestRoll('FamousTable: range', 4250, 1, 4250),
            new TestRoll('FamousTable: range', 3400, 1, 4250),
            new TestRoll('Number Infamous', 3, 2, 4),
            new TestRoll('FamousTable: range', 3300, 1, 4250),
            new TestRoll('FamousTable: range', 3300, 1, 4250),
            new TestRoll('FamousTable: range', 200, 1, 4250),
            new TestRoll('FamousTable: range', 3300, 1, 4250),
            new TestRoll('FamousTable: range', 3300, 1, 4250),
            new TestRoll('FamousTable: range', 3300, 1, 4250),
            new TestRoll('FamousTable: range', 3300, 1, 4250),
            new TestRoll('FamousTable: range', 400, 1, 4250),
        ]);

        $this->services->randomFamous->determineFamous($city, $postData);

        $this->assertSame(4, count($city->famous));
        $this->assertSame(3, count($city->infamous));
    }
}
