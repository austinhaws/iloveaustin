<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\ILoveAustin\Constants\BooleanRandom;
use App\Http\Controllers\ILoveAustin\Constants\PopulationType;
use App\Http\Controllers\ILoveAustin\Models\City\City;
use App\Http\Controllers\ILoveAustin\Models\Post\PostData;
use App\Http\Controllers\ILoveAustin\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomGuildsServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomGuildsService::determineGuilds
     */
    public function testNoProfessions()
    {
        $postData = new PostData();

        $city = new City();
        $city->populationType = PopulationType::METROPOLIS;

        $this->services->random->setRolls([
            new TestRoll('Guild Modifier', 2, 0, 7),
        ]);

        $this->services->randomGuildService->determineGuilds($city, $postData);
        $this->services->random->verifyRolls();

        $this->assertSame(0, count($city->guilds));
    }

    public function testWithProfessions()
    {
        // create a bunch of professions - copied from professions service test
        $this->services->random->setRolls(
            array_fill(0, 21, new TestRoll('ProfessionTable: range', $this->services->realRandom->randRangeInt('unit test setup - single profession', 1, 10000), 1, 10000))
        );

        $postData = new PostData();
        $postData->professions = BooleanRandom::TRUE;

        $city = new City();
        $city->populationType = PopulationType::METROPOLIS;
        $city->populationSize = 90000;
        $this->services->randomProfessions->determineProfessions($city, $postData);

        $this->assertSame(165, count($city->professions));

        $this->services->random->verifyRolls();

        // now generate guilds against those professions
        $this->services->random->setRolls([
            new TestRoll('Guild Modifier', 2, 0, 7),
        ]);

        $this->services->randomGuildService->determineGuilds($city, $postData);
        $this->services->random->verifyRolls();

        $this->assertSame(42, count($city->guilds));
        $this->assertSame('Artists', $city->guilds[2]->guild);
        $this->assertSame(5, $city->guilds[2]->total);

        $total = array_reduce($city->guilds, function ($carry, $guild) {
            return $carry + $guild->total;
        }, 0);
        $this->assertNotSame(false, array_search($total, [361, 362]));

        $total = array_reduce($city->guilds, function ($carry, $guild) {
            return max($carry, $guild->total);
        }, 0);
        $this->assertNotSame(false, array_search($total, [77, 78]));
    }
}
