<?php

namespace App\Http\Controllers\CityGen\Models\City;

class CityProfession
{
    /** @var string Profession:: enum */
    public $profession;
    /** @var int */
    public $total;

    /**
     * CityProfession constructor.
     * @param string $profession Profession::
     * @param int $total
     */
    public function __construct(string $profession, int $total)
    {
        $this->profession = $profession;
        $this->total = $total;
    }
}
