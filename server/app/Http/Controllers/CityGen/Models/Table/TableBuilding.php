<?php

namespace App\Http\Controllers\CityGen\Models\Table;

use App\Http\Controllers\CityGen\Models\MinMax;

class TableBuilding
{
    /** @var string Building enum */
    public $building;
    /** @var MinMax */
    public $qualityMinMax;

    /**
     * TableBuilding constructor.
     * @param string $building
     * @param MinMax $qualityMinMax
     */
    public function __construct(string $building, MinMax $qualityMinMax)
    {
        $this->building = $building;
        $this->qualityMinMax = $qualityMinMax;
    }
}
