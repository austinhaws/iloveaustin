<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\NPCClass;

class NPCClassRandomClassTable extends BaseTable
{
    function getTable()
    {
        return array(
            57 => NPCClass::WARRIOR,
            115 => NPCClass::ADEPT,
            197 => NPCClass::ARISTOCRAT,
            280 => NPCClass::BARBARIAN,
            335 => NPCClass::BARD,
            368 => NPCClass::CLERIC,
            672 => NPCClass::COMMONER,
            704 => NPCClass::DRUID,
            758 => NPCClass::EXPERT,
            818 => NPCClass::FIGHTER,
            833 => NPCClass::MONK,
            846 => NPCClass::PALADIN,
            893 => NPCClass::RANGER,
            975 => NPCClass::ROGUE,
            992 => NPCClass::SORCERER,
            999 => NPCClass::WIZARD,
            1000 => NPCClass::MONSTER,
        );
    }
}
