<?php

namespace App\Http\Controllers\ILoveAustin;

use App\Http\Controllers\ILoveAustin\Services\ServicesService;
use Laravel\Lumen\Routing\Controller;

class ControllerBase extends Controller
{
    protected $services;

    public function __construct(ServicesService $servicesService)
    {
        $this->services = $servicesService;
    }
}
