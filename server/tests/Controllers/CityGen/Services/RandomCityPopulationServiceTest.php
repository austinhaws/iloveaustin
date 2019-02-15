<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\RandomCity\RandomService;
use App\Http\Controllers\CityGen\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class RandomCityPopulationServiceTest extends BaseTestCase
{
    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomCityPopulationService::determinePopulation
     */
    public function testGetTableResultRange_populationTypeGiven()
    {
        foreach (PopulationType::getConstants() as $populationType) {
            $this->services->random->setRolls([new TestRoll('Random Population Size', TestRoll::RANDOM, TestRoll::ANY, TestRoll::ANY)]);

            $postData = new PostData();
            $postData->populationType = $populationType;

            $city = new City();
            $this->services->randomCityPopulation->determinePopulation($city, $postData);

            $this->services->random->verifyRolls();

            $this->assertSame($populationType, $city->populationType);
        }
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomCityPopulationService::determinePopulation
     */
    public function testGetTableResultRange_random()
    {
        $this->services->random->setRolls([
            new TestRoll('getTableResultRandom-PopulationTypeTable', 0, 0, 7),
            new TestRoll('Random Population Size', 30, 20, 80),
        ]);

        $postData = new PostData();
        $postData->populationType = RandomService::RANDOM;

        $city = new City();
        $this->services->randomCityPopulation->determinePopulation($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(PopulationType::THORP, $city->populationType);
    }

    public function testGetTableResultRange_userEntered_low()
    {
        $postData = new PostData();
        $postData->populationType = 1;

        $city = new City();
        $this->services->randomCityPopulation->determinePopulation($city, $postData);

        $this->assertSame(PopulationType::THORP, $city->populationType);
        $this->assertSame(20, $city->populationSize);
    }

    public function testGetTableResultRange_userEntered_mid()
    {
        $postData = new PostData();
        $postData->populationType = 1500;

        $city = new City();
        $this->services->randomCityPopulation->determinePopulation($city, $postData);

        $this->assertSame(PopulationType::SMALL_TOWN, $city->populationType);
        $this->assertSame(1500, $city->populationSize);
    }

    public function testGetTableResultRange_userEntered_big()
    {
        $postData = new PostData();
        $postData->populationType = 999999999;

        $city = new City();
        $this->services->randomCityPopulation->determinePopulation($city, $postData);

        $this->assertSame(PopulationType::METROPOLIS, $city->populationType);
        $this->assertSame(999999999, $city->populationSize);
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomCityPopulationService::determinePopulation
     */
    public function testResourcesLargeTown()
    {
        $postData = new PostData();
        $postData->populationType = PopulationType::LARGE_TOWN;

        $this->services->random->setRolls([
            new TestRoll('Random Population Size', 30, 2001, 5000),
        ]);

        $city = new City();
        $this->services->randomCityPopulation->determinePopulation($city, $postData);

        $this->services->random->verifyRolls();

        $this->assertSame(7000, $city->goldPieceLimit);
        $this->assertSame(10500.0, $city->wealth);
        $this->assertSame(105.0, $city->kingIncome);
        $this->assertSame(525.0, $city->magicResources);
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomCityPopulationService::determinePopulation
     */
    public function testResourcesSpecificSize()
    {
        $postData = new PostData();
        $postData->populationType = 999888;

        $city = new City();
        $this->services->randomCityPopulation->determinePopulation($city, $postData);

        $this->assertSame(PopulationType::METROPOLIS, $city->populationType);
        $this->assertSame(160000, $city->goldPieceLimit);
        $this->assertSame(7999104000.0, $city->wealth);
        $this->assertSame(3999552.0, $city->kingIncome);
        $this->assertSame(799910400.0, $city->magicResources);
    }

    /**
     * @covers \App\Http\Controllers\CityGen\Services\RandomCity\RandomCityPopulationService::determinePopulation
     */
    public function testDecimals()
    {
        $postData = new PostData();
        $postData->populationType = 125;

        $city = new City();
        $this->services->randomCityPopulation->determinePopulation($city, $postData);

        $this->assertSame(PopulationType::HAMLET, $city->populationType);
        $this->assertSame(100, $city->goldPieceLimit);
        $this->assertSame(625.0, $city->wealth);
        $this->assertSame(1.25, $city->kingIncome);
        $this->assertSame(0.0, $city->magicResources);
    }
}
