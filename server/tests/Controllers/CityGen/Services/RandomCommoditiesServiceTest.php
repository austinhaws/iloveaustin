<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\ILoveAustin\Constants\PopulationType;
use App\Http\Controllers\ILoveAustin\Models\City\City;
use App\Http\Controllers\ILoveAustin\Models\Post\PostData;
use App\Http\Controllers\ILoveAustin\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomCommoditiesServiceTest extends BaseTestCase
{

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomCommoditiesService::determineCommodities
     */
    public function testRandomCommodities()
    {
        $postData = new PostData();

        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;

        $this->services->random->setRolls([
            new TestRoll('Number Exports', 4, 2, 4),
            new TestRoll('CommoditiesTable: range', 4, 1, 3700),
            new TestRoll('CommoditiesTable: range', 5, 1, 3700),
            new TestRoll('CommoditiesTable: range', 550, 1, 3700),
            new TestRoll('CommoditiesTable: range', 4, 1, 3700),
            new TestRoll('CommoditiesTable: range', 20, 1, 3700),
            new TestRoll('CommoditiesTable: range', 3700, 1, 3700),
            new TestRoll('Number Imports', 3, 2, 4),
            new TestRoll('CommoditiesTable: range', 3300, 1, 3700),
            new TestRoll('CommoditiesTable: range', 3300, 1, 3700),
            new TestRoll('CommoditiesTable: range', 200, 1, 3700),
            new TestRoll('CommoditiesTable: range', 3300, 1, 3700),
            new TestRoll('CommoditiesTable: range', 3300, 1, 3700),
            new TestRoll('CommoditiesTable: range', 3300, 1, 3700),
            new TestRoll('CommoditiesTable: range', 3300, 1, 3700),
            new TestRoll('CommoditiesTable: range', 400, 1, 3700),
        ]);

        $this->services->randomCommodities->determineCommodities($city, $postData);

        $this->assertSame(4, count($city->commoditiesExport));
        $this->assertSame(3, count($city->commoditiesImport));
    }
}
