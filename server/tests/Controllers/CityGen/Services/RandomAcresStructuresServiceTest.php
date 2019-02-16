<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\ILoveAustin\Constants\PopulationType;
use App\Http\Controllers\ILoveAustin\Models\City\City;
use App\Http\Controllers\ILoveAustin\Util\RollRatio;
use App\Http\Controllers\ILoveAustin\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomAcresStructuresServiceTest extends BaseTestCase
{

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomAcresStructuresService::randomAcres
     */
    public function testRandomAcres()
    {
        $tests = [
            ['percent' => 45, 'result' => 217],
            ['percent' => 0, 'result' => 1000],
            ['percent' => 100, 'result' => 111],
        ];
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->populationSize = 1000;

        foreach ($tests as $test) {
            $this->services->random->setRolls([
                new TestRoll('randomAcres', RollRatio::ratioPercent($test['percent'])),
            ]);

            $this->services->randomAcresStructures->randomAcres($city);

            $this->services->random->verifyRolls();

            $this->assertSame($test['result'], $city->acres, "${test['percent']}% => ${test['result']}");
        }
    }

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomAcresStructuresService::randomNumStructures
     */
    public function testRandomNumStructures()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->populationSize = 1000;
        $city->acres = 230;

        $this->services->random->setRolls([
            new TestRoll('randomNumStructures', RollRatio::ratioPercent(50)),
        ]);

        $this->services->randomAcresStructures->randomNumStructures($city);

        $this->services->random->verifyRolls();

        $this->assertSame(115, $city->numStructures);
    }
}
