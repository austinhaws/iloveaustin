<?php

namespace App\Http\Controllers\ILoveAustin\Dao;


class Daos
{
    /** @var AccountDao */
    public $account;
    public $snapshot;

    public function __construct(
        ?AccountDao $accountDao = null,
        ?SnapshotDao $snapshotDao = null
    )
    {
        $this->account = $accountDao;
        $this->snapshot = $snapshotDao;
    }
}
