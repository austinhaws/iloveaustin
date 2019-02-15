<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\Race;

class RacesRandomTable extends BaseTable
{
    function getTable()
    {
        return array(
            52 => Race::HUMAN,
            63 => Race::HALFLING,
            72 => Race::ELF,
            80 => Race::DWARF,
            87 => Race::GNOME,
            93 => Race::HALFELF,
            98 => Race::HALFORC,
            100 => Race::OTHER,
        );
    }
}
