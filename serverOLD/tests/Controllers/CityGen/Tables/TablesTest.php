<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\ILoveAustin\Constants\Table;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use RuntimeException;

final class TablesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTablesCreation()
    {
        try {
            $tables = (new ReflectionClass(Table::class))->getConstants();
            foreach ($tables as $tableName) {
                $table = Table::getTable($tableName);

                $this->assertNotEquals(0, count($table->getTable()));
            }
        } catch (\ReflectionException $e) {
            throw new RuntimeException($e);
        }
    }

    public function testReuseTables()
    {
        // getting the table a second time should return the same table
        $table1 = Table::getTable(Table::FAMOUS);
        $table2 = Table::getTable(Table::FAMOUS);
        $this->assertSame($table1, $table2);
    }
}
