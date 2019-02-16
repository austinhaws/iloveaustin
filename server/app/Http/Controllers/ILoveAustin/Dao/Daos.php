<?php

namespace App\Http\Controllers\ILoveAustin\Dao;


class Daos
{
    /** @var AccountDao */
    public $account;

    public function __construct(
        ?AccountDao $accountDao = null
    )
    {
        $this->account = $accountDao;
    }
}
