<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\ILoveAustin\Constants\PopulationType;
use App\Http\Controllers\ILoveAustin\Models\City\City;
use App\Http\Controllers\ILoveAustin\Models\Post\PostData;
use App\Http\Controllers\ILoveAustin\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomPowerCentersServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomPowerCentersService::determinePowerCenters
     */
    public function testDeterminePowerCentersNone()
    {
        $city = new City();
        $city->populationType = PopulationType::THORP;
        $city->wealth = 1000;

        // true
        $postData = new PostData();

        $this->services->random->setRolls([
            new TestRoll('Power Level', 0, 0, 1),
        ]);

        $this->services->randomPowerCenters->determinePowerCenters($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(0, $city->influencePointsUnabsorbed);
        $this->assertSame(0, count($city->powerCenters));
    }

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomPowerCentersService::determinePowerCenters
     */
    public function testDeterminePowerCentersLots()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_TOWN;
        $city->wealth = 1000;

        // true
        $postData = new PostData();

        $this->services->random->setRolls([
            new TestRoll('Power Level', 3, 2, 5),
            new TestRoll('Influence points', 353, 188, 353),

            new TestRoll('PowerCenterTypeTable: range', 250, 1, 1000),
            new TestRoll('Influence', 84, 84, 103),
            new TestRoll('PowerCenterAlignmentTable: range', 10, 1, 100),
            new TestRoll('NPCClassRandomClassTable: range', 999, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 9, 1, 9),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),

            new TestRoll('NPCClassRandomClassTable: range', 700, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 7, 1, 11),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),

            new TestRoll('PowerCenterTypeTable: range', 750, 1, 1000),
            new TestRoll('Influence', 90, 84, 103),
            new TestRoll('PowerCenterAlignmentTable: range', 85, 1, 100),
            new TestRoll('NPCClassRandomClassTable: range', 663, 1, 1000),
            new TestRoll('NPC level bonus', 0, 0, 1),
            new TestRoll('NPC level', 20, 1, 20),
            new TestRoll('NPC Level Increase', 1, 1, 10),
            new TestRoll('NPC Level Increase', 2, 1, 10),
            new TestRoll('NPC Level Increase', 3, 1, 10),
            new TestRoll('NPC Level Increase', 4, 1, 10),
            new TestRoll('NPC Level Increase', 5, 1, 10),

            new TestRoll('NPCClassRandomClassTable: range', 597, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 7, 1, 20),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),

            new TestRoll('PowerCenterTypeTable: range', 449, 1, 1000),
            new TestRoll('Influence', 17, 84, 103),
            new TestRoll('PowerCenterAlignmentTable: range', 62, 1, 100),
            new TestRoll('NPCClassRandomClassTable: range', 478, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 7, 1, 20),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),

            new TestRoll('NPCClassRandomClassTable: range', 222, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 10, 1, 9),
            new TestRoll('NPC Level Increase', 1, 1, 10),
            new TestRoll('NPC Level Increase', 2, 1, 10),
            new TestRoll('NPC Level Increase', 3, 1, 10),
            new TestRoll('NPC Level Increase', 4, 1, 10),

            new TestRoll('NPCClassRandomClassTable: range', 222, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 10, 1, 9),
            new TestRoll('NPC Level Increase', 1, 1, 10),
            new TestRoll('NPC Level Increase', 2, 1, 10),
            new TestRoll('NPC Level Increase', 3, 1, 10),
            new TestRoll('NPC Level Increase', 4, 1, 10),

            new TestRoll('NPCClassRandomClassTable: range', 222, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 10, 1, 9),
            new TestRoll('NPC Level Increase', 1, 1, 10),
            new TestRoll('NPC Level Increase', 2, 1, 10),
            new TestRoll('NPC Level Increase', 3, 1, 10),
            new TestRoll('NPC Level Increase', 4, 1, 10),

            new TestRoll('NPCClassRandomClassTable: range', 222, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 10, 1, 9),
            new TestRoll('NPC Level Increase', 1, 1, 10),
            new TestRoll('NPC Level Increase', 2, 1, 10),
            new TestRoll('NPC Level Increase', 3, 1, 10),
            new TestRoll('NPC Level Increase', 4, 1, 10),

            new TestRoll('NPCClassRandomClassTable: range', 222, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 10, 1, 9),
            new TestRoll('NPC Level Increase', 1, 1, 10),
            new TestRoll('NPC Level Increase', 2, 1, 10),
            new TestRoll('NPC Level Increase', 3, 1, 10),
            new TestRoll('NPC Level Increase', 4, 1, 10),

            new TestRoll('NPCClassRandomClassTable: range', 222, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 10, 1, 9),
            new TestRoll('NPC Level Increase', 1, 1, 10),
            new TestRoll('NPC Level Increase', 2, 1, 10),
            new TestRoll('NPC Level Increase', 3, 1, 10),
            new TestRoll('NPC Level Increase', 4, 1, 10),
        ]);

        $this->services->randomPowerCenters->determinePowerCenters($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(70.60000000000001, $city->influencePointsUnabsorbed);
        $this->assertSame(3, count($city->powerCenters));

        // check sorting
        foreach ($city->powerCenters as $powerCenter) {
            $this->assertIsSorted($powerCenter->npcs, function ($npc) {
                return $npc->class;
            });
        }
    }

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomPowerCentersService::determinePowerCenters
     */
    public function testUseRemainder()
    {
        $city = new City();
        $city->populationType = PopulationType::LARGE_TOWN;
        $city->wealth = 1000;

        // true
        $postData = new PostData();

        $this->services->random->setRolls([
            new TestRoll('Power Level', 1, 2, 5),
            new TestRoll('Influence points', 353, 188, 353),

            new TestRoll('PowerCenterTypeTable: range', 250, 1, 1000),
            new TestRoll('Influence', 1, 254, 310),
            new TestRoll('PowerCenterAlignmentTable: range', 10, 1, 100),
            new TestRoll('NPCClassRandomClassTable: range', 999, 1, 1000),
            new TestRoll('NPC level bonus', 1, 0, 1),
            new TestRoll('NPC level', 9, 1, 9),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),
            new TestRoll('NPC Level Increase', 10, 1, 10),
        ]);

        $this->services->randomPowerCenters->determinePowerCenters($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(70.60000000000001, $city->influencePointsUnabsorbed);
        $this->assertSame(1, count($city->powerCenters));

        // check sorting
        foreach ($city->powerCenters as $powerCenter) {
            $this->assertIsSorted($powerCenter->npcs, function ($npc) {
                return $npc->class;
            });
        }
    }
}
