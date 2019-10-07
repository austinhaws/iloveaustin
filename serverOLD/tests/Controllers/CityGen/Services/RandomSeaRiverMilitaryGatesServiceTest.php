<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\ILoveAustin\Constants\BooleanRandom;
use App\Http\Controllers\ILoveAustin\Constants\PopulationType;
use App\Http\Controllers\ILoveAustin\Models\City\City;
use App\Http\Controllers\ILoveAustin\Models\Post\PostData;
use App\Http\Controllers\ILoveAustin\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomSeaRiverMilitaryGatesServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomSeaRiverMilitaryGatesService::determineZones
     */
    public function testDetermineZones_hasSeas()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = BooleanRandom::FALSE;

        // true
        $postData = new PostData();
        $postData->hasSea = BooleanRandom::TRUE;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->assertSame(BooleanRandom::TRUE, $city->hasSea);

        // false
        $postData->hasSea = BooleanRandom::FALSE;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->assertSame(BooleanRandom::FALSE, $city->hasSea);

        // random - yes
        $this->services->random->setRolls([
            new TestRoll('Has Sea', 25, 1, 100),
        ]);
        $postData->hasSea = BooleanRandom::RANDOM;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(BooleanRandom::TRUE, $city->hasSea);

        // random - no
        $this->services->random->setRolls([
            new TestRoll('Has Sea', 73, 1, 100),
        ]);
        $postData->hasSea = BooleanRandom::RANDOM;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(BooleanRandom::FALSE, $city->hasSea);
    }

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomSeaRiverMilitaryGatesService::determineZones
     */
    public function testDetermineZones_hasRiver()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = BooleanRandom::FALSE;

        // true
        $postData = new PostData();
        $postData->hasRiver = BooleanRandom::TRUE;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->assertSame(BooleanRandom::TRUE, $city->hasRiver);

        // false
        $postData->hasRiver = BooleanRandom::FALSE;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->assertSame(BooleanRandom::FALSE, $city->hasRiver);

        // random - yes
        $this->services->random->setRolls([
            new TestRoll('Has River', 25, 1, 100),
        ]);
        $postData->hasRiver = BooleanRandom::RANDOM;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(BooleanRandom::TRUE, $city->hasRiver);

        // random - no
        $this->services->random->setRolls([
            new TestRoll('Has River', 73, 1, 100),
        ]);
        $postData->hasRiver = BooleanRandom::RANDOM;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(BooleanRandom::FALSE, $city->hasRiver);
    }

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomSeaRiverMilitaryGatesService::determineZones
     */
    public function testDetermineZones_hasMilitary()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = BooleanRandom::FALSE;

        // true
        $postData = new PostData();
        $postData->hasMilitary = BooleanRandom::TRUE;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->assertSame(BooleanRandom::TRUE, $city->hasMilitary);

        // false
        $postData->hasMilitary = BooleanRandom::FALSE;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->assertSame(BooleanRandom::FALSE, $city->hasMilitary);

        // random - yes
        $this->services->random->setRolls([
            new TestRoll('Has Military', 7, 1, 100),
        ]);
        $postData->hasMilitary = BooleanRandom::RANDOM;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(BooleanRandom::TRUE, $city->hasMilitary);

        // random - no
        $this->services->random->setRolls([
            new TestRoll('Has Military', 73, 1, 100),
        ]);
        $postData->hasMilitary = BooleanRandom::RANDOM;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(BooleanRandom::FALSE, $city->hasMilitary);
    }

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomSeaRiverMilitaryGatesService::determineZones
     */
    public function testDetermineZones_hasGates()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = BooleanRandom::FALSE;

        // true
        $postData = new PostData();
        $postData->hasGates = BooleanRandom::TRUE;

        $this->services->random->setRolls([
            new TestRoll('Num Gates', 3, 1, 4),
        ]);
        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);
        $this->services->random->verifyRolls();

        $this->assertSame(3, $city->gates);

        // false
        $postData->hasGates = BooleanRandom::FALSE;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->assertSame(0, $city->gates);

        // random - yes
        $this->services->random->setRolls([
            new TestRoll('Has Walls', 7, 1, 100),
            new TestRoll('Num Gates', 4, 1, 4),
        ]);
        $postData->hasGates = BooleanRandom::RANDOM;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(4, $city->gates);

        // random - no
        $this->services->random->setRolls([
            new TestRoll('Has Walls', 73, 1, 100),
        ]);
        $postData->hasGates = BooleanRandom::RANDOM;

        $this->services->randomSeaRiverMilitaryGates->determineZones($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(0, $city->gates);
    }
}
