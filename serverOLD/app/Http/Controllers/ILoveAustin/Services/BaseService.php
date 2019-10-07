<?php

namespace App\Http\Controllers\ILoveAustin\Services;

use App\Http\Controllers\ILoveAustin\Dao\Daos;

class BaseService
{
    /** @var ServicesService */
    protected $services;
    /** @var Daos */
    protected $daos;

    public function __construct(ServicesService $services, Daos $daos)
    {
        $this->services = $services;
        $this->daos = $daos;
    }
}
