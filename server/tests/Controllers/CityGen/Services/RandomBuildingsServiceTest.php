<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\ILoveAustin\Constants\PopulationType;
use App\Http\Controllers\ILoveAustin\Constants\Ward;
use App\Http\Controllers\ILoveAustin\Models\City\City;
use App\Http\Controllers\ILoveAustin\Models\City\CityWard;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomBuildingsServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomBuildingsService::generateBuildings
     */
    public function testDetermineWards()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;

        $ward = new CityWard();
        $ward->type = Ward::MARKET;
        $ward->acres = 3.5;

        $this->services->random->setRolls([
            // new TestRoll('Ward acres used', 1.5, 1, 2),
        ]);

        $this->services->randomBuildings->generateBuildings($city, $ward, null);

        $this->services->random->verifyRolls();


        $this->assertSame(3, count($ward->buildings));
    }
}
