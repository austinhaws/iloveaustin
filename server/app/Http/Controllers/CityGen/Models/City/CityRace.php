<?php

namespace App\Http\Controllers\CityGen\Models\City;

class CityRace
{
    /** @var string Race:: */
    public $race;
    /** @var int */
    public $total;

    public function __construct(string $race, int $total)
    {
        $this->race = $race;
        $this->total = $total;
    }
}
