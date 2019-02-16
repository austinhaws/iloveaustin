<?php

namespace App\Http\Controllers\ILoveAustin\Services;

use App\Http\Controllers\ILoveAustin\Dao\Daos;

class ServicesService
{
    /** @var LoginService */
    public $login;
    /** @var SnapshotService */
    public $snapshot;

    public function __construct(
        ?Daos $daos = null
    )
    {
        $this->login = new LoginService($this, $daos);
        $this->snapshot = new SnapshotService($this, $daos);
    }
}
