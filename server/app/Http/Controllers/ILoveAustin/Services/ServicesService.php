<?php

namespace App\Http\Controllers\ILoveAustin\Services;

use App\Http\Controllers\ILoveAustin\Dao\Daos;

class ServicesService
{
    /** @var LoginService */
    public $loginService;

    public function __construct(
        ?Daos $daos = null
    )
    {
        $this->loginService = new LoginService($this, $daos);
    }
}
