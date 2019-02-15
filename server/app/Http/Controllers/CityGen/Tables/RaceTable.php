<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\Race;

class RaceTable extends BaseTable
{
    function getTable()
    {
        return array(
            Race::HUMAN,
            Race::HALFLING,
            Race::ELF,
            Race::DWARF,
            Race::GNOME,
            Race::HALFELF,
            Race::HALFORC,
            Race::OTHER,
        );
    }
}
