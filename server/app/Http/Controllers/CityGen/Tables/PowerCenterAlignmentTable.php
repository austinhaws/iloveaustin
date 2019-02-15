<?php

namespace App\Http\Controllers\CityGen\Tables;

class PowerCenterAlignmentTable extends BaseTable
{
    function getTable()
    {
        return array(
            35 => 'Lawful Good',
            39 => 'Neutral Good',
            41 => 'Chaotic Good',
            61 => 'Lawful Neutral',
            63 => 'True Neutral',
            64 => 'Chaotic Neutral',
            90 => 'Lawful Evil',
            98 => 'Neutral Evil',
            100 => 'Chaotic Evil',
        );
    }
}
