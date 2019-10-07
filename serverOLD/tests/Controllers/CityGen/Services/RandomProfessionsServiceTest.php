<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\ILoveAustin\Constants\BooleanRandom;
use App\Http\Controllers\ILoveAustin\Constants\PopulationType;
use App\Http\Controllers\ILoveAustin\Models\City\City;
use App\Http\Controllers\ILoveAustin\Models\Post\PostData;
use App\Http\Controllers\ILoveAustin\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomProfessionsServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomProfessionsService::determineProfessions
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomProfessionsService::addProfession
     */
    public function testNoProfessionsGenerated()
    {
        $postData = new PostData();
        $postData->professions = BooleanRandom::FALSE;

        $city = new City();
        $city->populationType = PopulationType::METROPOLIS;
        $city->populationSize = 90000;
        $this->services->randomProfessions->determineProfessions($city, $postData);

        $this->assertSame(0, count($city->professions));
    }

    /**
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomProfessionsService::determineProfessions
     * @covers \App\Http\Controllers\ILoveAustin\Services\RandomCity\RandomProfessionsService::addProfession
     */
    public function testGeneration()
    {
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

        // sorted
        $professions = array_map(function ($profession) { return $profession->profession; }, $city->professions);
        $isSorted = array_reduce($professions, function ($carry, $profession) {
            return $carry === null ? null : (strcmp($profession, $carry) > 0 ? $profession : null);
        }, '');
        $this->assertNotEquals(null, $isSorted);
    }
}
