<?php

namespace App\Http\Controllers\ILoveAustin\Dao;

class BaseDao
{
    /** @var Daos */
    protected $daos;

    public function __construct(Daos $daos)
    {
        $this->daos = $daos;
    }
}
