<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\BooleanRandom;
use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Constants\Ward;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Models\Post\WardAdded;
use App\Http\Controllers\CityGen\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomWardsServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testDetermineWards()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded([], Ward::SLUM),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // Slum / Market / Merchant
        $this->assertSame(3, count($city->wards));
        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SLUM;
        })), 'Has sea ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testNumGates()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 2;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
            new TestRoll('Ward acres used', 4.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // 2 gates / market / merchant
        $this->assertSame(4, count($city->wards));
        $this->assertSame(2, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::GATE;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testHasSeaNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::TRUE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));
        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SEA && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testHasSeaNotAlreadyDoneWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::TRUE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
            new TestRoll('Ward acres used', 4.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));
        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SEA;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testHasSeaAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::TRUE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::SEA),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SEA;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testHasRiverNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::TRUE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));
        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::RIVER;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testHasRiverAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::TRUE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::RIVER),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::RIVER;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testHasMilitaryNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::TRUE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));
        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MILITARY && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testHasMilitaryAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::TRUE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::MILITARY),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MILITARY && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testHasMilitaryInsideWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::TRUE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::MILITARY),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
            new TestRoll('Ward acres used', 4.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MILITARY && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testAdministrationSmallTownAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_TOWN;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::ADMINISTRATION),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 2, 7),
            new TestRoll('Ward acres used', 2.5, 2, 7),
            new TestRoll('Ward acres used', 3.5, 2, 7),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testAdministrationSmallTownNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_TOWN;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 2, 7),
            new TestRoll('Ward acres used', 2.5, 2, 7),
            new TestRoll('Ward acres used', 3.5, 2, 7),
            new TestRoll('Ward acres used', 4.5, 2, 7),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testAdministrationSmallerThanSmallTownAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::ADMINISTRATION),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 2, 5),
            new TestRoll('Ward acres used', 2.5, 2, 5),
            new TestRoll('Ward acres used', 3.5, 2, 5),
            new TestRoll('Ward acres used', 4.5, 2, 5),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testAdministrationSmallerThanSmallTownNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 2, 5),
            new TestRoll('Ward acres used', 2.5, 2, 5),
            new TestRoll('Ward acres used', 3.5, 2, 5),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testAdministrationLargerThanSmallTownAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_TOWN;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::ADMINISTRATION),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 3, 9),
            new TestRoll('Ward acres used', 2.5, 3, 9),
            new TestRoll('Ward acres used', 3.5, 3, 9),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testAdministrationLargerThanSmallTownNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_TOWN;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 3, 9),
            new TestRoll('Ward acres used', 2.5, 3, 9),
            new TestRoll('Ward acres used', 3.5, 3, 9),
            new TestRoll('Ward acres used', 4.5, 3, 9),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testCraftsmenSmallCityAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::CRAFTSMEN),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 4, 11),
            new TestRoll('Ward acres used', 2.5, 4, 11),
            new TestRoll('Ward acres used', 3.5, 4, 11),
            new TestRoll('Ward acres used', 4.5, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testCraftsmenSmallCityNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 4, 11),
            new TestRoll('Ward acres used', 2.5, 4, 11),
            new TestRoll('Ward acres used', 3.5, 4, 11),
            new TestRoll('Ward acres used', 4.5, 4, 11),
            new TestRoll('Ward acres used', 5.5, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(5, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testCraftsmenSmallerThanSmallCityAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::CRAFTSMEN),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 2, 5),
            new TestRoll('Ward acres used', 2.5, 2, 5),
            new TestRoll('Ward acres used', 3.5, 2, 5),
            new TestRoll('Ward acres used', 4.5, 2, 5),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testCraftsmenSmallerThanSmallCityNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 2, 5),
            new TestRoll('Ward acres used', 2.5, 2, 5),
            new TestRoll('Ward acres used', 3.5, 2, 5),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(3, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testCraftsmenLargerThanSmallCityAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::CRAFTSMEN),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 5, 13),
            new TestRoll('Ward acres used', 2.5, 5, 13),
            new TestRoll('Ward acres used', 3.5, 5, 13),
            new TestRoll('Ward acres used', 4.5, 5, 13),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testCraftsmenLargerThanSmallCityNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 5, 13),
            new TestRoll('Ward acres used', 2.5, 5, 13),
            new TestRoll('Ward acres used', 3.5, 5, 13),
            new TestRoll('Ward acres used', 4.5, 5, 13),
            new TestRoll('Ward acres used', 5.5, 5, 13),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(5, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testMarketAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::MARKET),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(2, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MARKET && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testMerchantAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::MERCHANT),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(2, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MARKET && $ward->insideWalls;
        })), 'Has tested ward');
    }


    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testPatriciateMetropolisMetropolisMetropolisMetropolisAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::METROPOLIS;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::PATRICIATE),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 6, 15),
            new TestRoll('Ward acres used', 2.5, 6, 15),
            new TestRoll('Ward acres used', 3.5, 6, 15),
            new TestRoll('Ward acres used', 4.5, 6, 15),
            new TestRoll('Ward acres used', 5.5, 6, 15),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(5, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::PATRICIATE && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testPatriciateMetropolisNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::METROPOLIS;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 6, 15),
            new TestRoll('Ward acres used', 2.5, 6, 15),
            new TestRoll('Ward acres used', 3.5, 6, 15),
            new TestRoll('Ward acres used', 4.5, 6, 15),
            new TestRoll('Ward acres used', 5.5, 6, 15),
            new TestRoll('Ward acres used', 6.5, 6, 15),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(6, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::PATRICIATE && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testPatriciateSmallerThanMetropolisAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::PATRICIATE),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 5, 13),
            new TestRoll('Ward acres used', 2.5, 5, 13),
            new TestRoll('Ward acres used', 3.5, 5, 13),
            new TestRoll('Ward acres used', 4.5, 5, 13),
            new TestRoll('Ward acres used', 5.5, 5, 13),
            new TestRoll('Ward acres used', 6.5, 5, 13),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(6, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::PATRICIATE && $ward->insideWalls;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testPatriciateSmallerThanMetropolisNotAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 5, 13),
            new TestRoll('Ward acres used', 2.5, 5, 13),
            new TestRoll('Ward acres used', 3.5, 5, 13),
            new TestRoll('Ward acres used', 4.5, 5, 13),
            new TestRoll('Ward acres used', 5.5, 5, 13),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(5, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::PATRICIATE;
        })), 'Has tested ward');
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomWardsService::determineWards
     */
    public function testGateAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 1;
        $city->acres = 1;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::GATE),
            new WardAdded(null, Ward::GATE),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1.5, 1, 2),
            new TestRoll('Ward acres used', 2.5, 1, 2),
            new TestRoll('Ward acres used', 3.5, 1, 2),
            new TestRoll('Ward acres used', 4.5, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        // sea/market/merchant
        $this->assertSame(4, count($city->wards));

        $this->assertSame(2, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::GATE;
        })), 'Has tested ward');
    }

    public function testRandomWardPatriciateSmallCity()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 17;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 1, 1, 100),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 70, 1, 100),
            new TestRoll('Ward acres used', 11, 4, 11),
            new TestRoll('Ward Type', 70, 1, 100),
            new TestRoll('Ward acres used', 11, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(7, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::PATRICIATE && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    // only one patriciate
    public function testRandomWardPatriciateSmallCityAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 21;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::PATRICIATE),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 1, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Odoriferous inside walls?', 25, 1, 100),
            new TestRoll('Ward acres used', 110, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(6, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::PATRICIATE && $ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomWardPatriciateSmallerThanSmallCity()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 3;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 1, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(3, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::PATRICIATE;
        })), 'Has tested ward');
    }

    public function testRandomWardAdministrationSmallCity()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 17;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 11, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 110, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(5, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    // only one patriciate
    public function testRandomWardAdministrationSmallCityAlreadyDone()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 21;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::ADMINISTRATION),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 11, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Odoriferous inside walls?', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Odoriferous inside walls?', 25, 1, 100),
            new TestRoll('Ward acres used', 110, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(6, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION && $ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomWardAdministrationSmallerThanSmallCity()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 3;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 11, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(3, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ADMINISTRATION;
        })), 'Has tested ward');
    }

    public function testRandomSea()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::TRUE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 7;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::SEA),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 13, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 13, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 13, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 13, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(7, count($city->wards));

        $this->assertSame(4, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SEA;
        })), 'Has tested ward');
    }

    public function testRandomSeaNoSea()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 7;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 13, 1, 100),
            new TestRoll('Ward Type', 13, 1, 100),
            new TestRoll('Ward Type', 13, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(7, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SEA;
        })), 'Has tested ward');
    }

    public function testRandomRiver()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::TRUE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 7;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::RIVER),
        ];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 16, 1, 100),
            new TestRoll('River inside walls?', 1, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 16, 1, 100),
            new TestRoll('River inside walls?', 1, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 16, 1, 100),
            new TestRoll('River inside walls?', 1, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Odoriferous inside walls?', 1, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(7, count($city->wards));

        $this->assertSame(4, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::RIVER;
        })), 'Has tested ward');
    }

    public function testRandomRiverNoRiver()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 7;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 16, 1, 100),
            new TestRoll('Ward Type', 16, 1, 100),
            new TestRoll('Ward Type', 16, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(7, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::RIVER;
        })), 'Has tested ward');
    }

    public function testRandomOdoriferousInsideWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 4;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Odoriferous inside walls?', 1, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Odoriferous inside walls?', 100, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(4, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ODORIFEROUS && $ward->insideWalls;
        })), 'Has tested ward');
        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ODORIFEROUS && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomOdoriferousNoGates()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 4;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 1, 2),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(4, count($city->wards));

        $this->assertSame(2, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::ODORIFEROUS && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomShantySmallCity()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 20;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 30, 1, 100),
            new TestRoll('Ward acres used', 110, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(5, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SHANTY && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomShantySmallerSmallCity()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 8;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 2, 5),
            new TestRoll('Ward acres used', 1, 2, 5),
            new TestRoll('Ward Type', 30, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 2, 5),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 110, 2, 5),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(4, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SHANTY;
        })), 'Has tested ward');
    }

    public function testRandomSlumSmallCityWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 20;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 40, 1, 100),
            new TestRoll('Ward acres used', 110, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(5, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SLUM && $ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomSlumSmallCityNoWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::SMALL_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 20;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward acres used', 1, 4, 11),
            new TestRoll('Ward Type', 40, 1, 100),
            new TestRoll('Ward acres used', 110, 4, 11),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(5, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SLUM && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomSlumSmallerSmallCity()
    {
        $city = new City();
        $city->populationType = PopulationType::VILLAGE;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 8;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 2, 5),
            new TestRoll('Ward acres used', 1, 2, 5),
            new TestRoll('Ward Type', 40, 1, 100),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 1, 2, 5),
            new TestRoll('Ward Type', 25, 1, 100),
            new TestRoll('Ward acres used', 110, 2, 5),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(4, count($city->wards));

        $this->assertSame(0, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::SLUM;
        })), 'Has tested ward');
    }

    public function testRandomMerchantSmallCityWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::METROPOLIS;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 35;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward Type', 55, 1, 100),
            new TestRoll('Ward acres used', 110, 6, 15),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(6, count($city->wards));

        $this->assertSame(2, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MERCHANT && $ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomMerchantSmallNoCityWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::METROPOLIS;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 35;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward Type', 55, 1, 100),
            new TestRoll('Ward acres used', 110, 6, 15),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(6, count($city->wards));

        $this->assertSame(2, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MERCHANT && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomMerchantSmallerMetropolis()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 25;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward Type', 55, 1, 100),
            new TestRoll('Ward Type', 40, 1, 100),
            new TestRoll('Ward acres used', 110, 5, 13),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(5, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MERCHANT && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomMarketWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 26;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::TRUE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Market inside walls?', 100, 1, 100),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Market inside walls?', 1, 1, 100),
            new TestRoll('Ward acres used', 110, 5, 13),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(6, count($city->wards));

        $this->assertSame(1, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MARKET && !$ward->insideWalls;
        })), 'Has tested ward');
        // the auto added market and the random one
        $this->assertSame(2, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MARKET && $ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomMarketNoWalls()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_CITY;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 26;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Ward acres used', 1, 5, 13),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Ward acres used', 110, 5, 13),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(6, count($city->wards));

        $this->assertSame(3, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::MARKET && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomCraftsmenLargeTownAlready2()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_TOWN;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 20;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::CRAFTSMEN),
            new WardAdded(null, Ward::CRAFTSMEN),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward Type', 76, 1, 100),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Ward acres used', 110, 3, 9),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(7, count($city->wards));

        $this->assertSame(2, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomCraftsmenLargeTownAlready1()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_TOWN;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 20;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::CRAFTSMEN),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward Type', 76, 1, 100),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward Type', 76, 1, 100),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Ward acres used', 1, 3, 9),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Ward acres used', 110, 3, 9),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(7, count($city->wards));

        $this->assertSame(2, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN && !$ward->insideWalls;
        })), 'Has tested ward');
    }

    public function testRandomCraftsmenMetropolis()
    {
        $city = new City();
        $city->populationType = PopulationType::METROPOLIS;
        $city->hasSea = BooleanRandom::FALSE;
        $city->hasRiver = BooleanRandom::FALSE;
        $city->hasMilitary = BooleanRandom::FALSE;
        $city->gates = 0;
        $city->acres = 60;

        // true
        $postData = new PostData();
        $postData->wardsAdded = [
            new WardAdded(null, Ward::CRAFTSMEN),
            new WardAdded(null, Ward::CRAFTSMEN),
        ];
        $postData->hasGates = BooleanRandom::FALSE;
        $postData->generateBuildings = BooleanRandom::FALSE;

        $this->services->random->setRolls([
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward Type', 76, 1, 100),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward Type', 76, 1, 100),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Ward acres used', 1, 6, 15),
            new TestRoll('Ward Type', 75, 1, 100),
            new TestRoll('Ward acres used', 110, 6, 15),
        ]);

        $this->services->randomWards->determineWards($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(10, count($city->wards));

        $this->assertSame(4, count(array_filter($city->wards, function ($ward) {
            return $ward->type === Ward::CRAFTSMEN && !$ward->insideWalls;
        })), 'Has tested ward');
    }
}
