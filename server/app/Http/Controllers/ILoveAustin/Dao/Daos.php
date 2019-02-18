<?php

namespace App\Http\Controllers\ILoveAustin\Dao;


class Daos
{
    /** @var AccountDao */
    public $account;
    /** @var SnapshotDao */
    public $snapshot;
    /** @var MonthlyDao */
    public $monthly;

    public function __construct()
    {
        $this->account = new AccountDao($this);
        $this->snapshot = new SnapshotDao($this);
        $this->monthly = new MonthlyDao($this);
    }
}
