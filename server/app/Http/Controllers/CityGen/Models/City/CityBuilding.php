<?php

namespace App\Http\Controllers\CityGen\Models\City;

class CityBuilding
{
    /** @var string Building:: */
    public $building;
    /** @var string */
    public $subType;
    /** @var int */
    public $quality;

    public function __construct(string $building, string $subType, int $quality)
    {
        $this->building = $building;
        $this->subType = $subType;
        $this->quality = $quality;
    }
}
