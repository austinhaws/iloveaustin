<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\NPCClass;

class NPCClassesMaxLevelTable extends BaseTable
{
    function getTable()
    {
        return array(
            NPCClass::ADEPT => 6,
            NPCClass::ARISTOCRAT => 4,
            NPCClass::BARBARIAN => 4,
            NPCClass::BARD => 6,
            NPCClass::CLERIC => 6,
            NPCClass::COMMONER => 16,
            NPCClass::DRUID => 6,
            NPCClass::EXPERT => 12,
            NPCClass::FIGHTER => 8,
            NPCClass::MONK => 4,
            NPCClass::MONSTER => 2,
            NPCClass::PALADIN => 3,
            NPCClass::RANGER => 3,
            NPCClass::ROGUE => 8,
            NPCClass::SORCERER => 4,
            NPCClass::WARRIOR => 8,
            NPCClass::WIZARD => 4,
        );
    }
}
