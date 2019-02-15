<?php

namespace App\Http\Controllers\CityGen\Models\City;

class CityPowerCenter
{
    /** @var int */
    public $id;
    /** @var string */
    public $type;
    /** @var string */
    public $alignment;
    /** @var float */
    public $wealth;
    /** @var int */
    public $influencePoints;
    /** @var CityNPCs[] */
    public $npcs = array();
    /** @var int aka: number_npcs */
    public $npcsTotal;
    /** @var int */
    public $numberCenters;

}
