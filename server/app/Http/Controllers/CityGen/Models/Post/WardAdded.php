<?php

namespace App\Http\Controllers\CityGen\Models\Post;

class WardAdded
{
    /** @var WardAddedBuilding[] */
    public $buildings;
    /** @var string Ward */
    public $ward;

    public function __construct($buildings = null, $ward = null)
    {
        $this->buildings = $buildings;
        $this->ward = $ward;
    }
}
