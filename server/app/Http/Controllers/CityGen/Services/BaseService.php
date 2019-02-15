<?php

namespace App\Http\Controllers\CityGen\Services;

class BaseService
{

    /**
     * @var ServicesService
     */
    protected $services;

    public function __construct(ServicesService $services)
    {
        $this->services = $services;
    }
}
