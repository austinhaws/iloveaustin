<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\NPCClass;

class NPCClassInfluenceTable extends BaseTable
{
    function getTable()
    {
        return array(
            NPCClass::ADEPT => 1,
            NPCClass::ARISTOCRAT => 1,
            NPCClass::BARBARIAN => 1,
            NPCClass::BARD => 1,
            NPCClass::CLERIC => 1,
            NPCClass::COMMONER => 0.5,
            NPCClass::DRUID => 1,
            NPCClass::EXPERT => 0.5,
            NPCClass::FIGHTER => 1,
            NPCClass::MONK => 1,
            NPCClass::PALADIN => 1,
            NPCClass::RANGER => 1,
            NPCClass::ROGUE => 1,
            NPCClass::SORCERER => 1,
            NPCClass::WARRIOR => 0.5,
            NPCClass::WIZARD => 1,
            NPCClass::MONSTER => 2,
        );
    }
}
