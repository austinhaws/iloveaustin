<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Util\TestRoll;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class TableServiceTest extends BaseTestCase
{
    public function testGetTableResultRange()
    {
        for ($x = 0; $x < 10; $x++) {
            $this->services->random->setRolls([new TestRoll('FamousTable: range', TestRoll::RANDOM, TestRoll::ANY, TestRoll::ANY)]);
            $this->assertTrue(!!$this->services->table->getTableResultRange(Table::FAMOUS));

            $this->services->random->verifyRolls();
        }
    }

    public function testGetTableResultIndex()
    {
        $this->assertEquals(40, $this->services->table->getTableResultIndex(Table::POPULATION_WEALTH, PopulationType::THORP));
        $this->assertEquals(15000, $this->services->table->getTableResultIndex(Table::POPULATION_WEALTH, PopulationType::SMALL_CITY));

    }

    public function testGetTableResultRandom()
    {
        $this->services->random->setRolls([new TestRoll("getTableResultRandom-NameWordsTable", 2, 0, 1140)]);
        $this->assertEquals('autumn', $this->services->table->getTableResultRandom(Table::NAME_WORDS));

        $this->services->random->verifyRolls();
    }

    public function testGetCustomTableResultRange()
    {
        $this->services->random->setRolls([new TestRoll("getCustomTableResultRandom-NameWordsTable", 2, 0, 1140)]);
        $this->assertEquals('autumn', $this->services->table->getCustomTableResultRange('getCustomTableResultRandom-NameWordsTable', Table::getTable(Table::NAME_WORDS)->getTable()));
        $this->services->random->verifyRolls();
    }

    public function testGetTableKeyFromRangeValue()
    {
        $this->assertEquals(PopulationType::THORP, $this->services->table->getTableKeyFromRangeValue(Table::POPULATION_SIZE, 30));
        $this->assertEquals(PopulationType::METROPOLIS, $this->services->table->getTableKeyFromRangeValue(Table::POPULATION_SIZE, 90000));
        $this->assertEquals(false, $this->services->table->getTableKeyFromRangeValue(Table::POPULATION_SIZE, 90001));
        $this->assertEquals(false, $this->services->table->getTableKeyFromRangeValue(Table::POPULATION_SIZE, 10));

    }
}
