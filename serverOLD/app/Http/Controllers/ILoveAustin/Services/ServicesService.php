<?php

namespace App\Http\Controllers\ILoveAustin\Services;

use App\Http\Controllers\ILoveAustin\Dao\Daos;

class ServicesService
{
    /** @var LoginService */
    public $login;
    /** @var MonthlyService */
    public $monthly;
    /** @var PeriodService  */
    public $period;
    /** @var SnapshotService */
    public $snapshot;

    public function __construct(
        ?Daos $daos = null
    )
    {
        $this->login = new LoginService($this, $daos);
        $this->snapshot = new SnapshotService($this, $daos);
        $this->monthly = new MonthlyService($this, $daos);
        $this->period = new PeriodService($this, $daos);
    }
}
