<?php

namespace App\Http\Controllers\ILoveAustin\Dao;

use Illuminate\Support\Facades\DB;

class SnapshotDao
{

    public function selectSnapshotsByToken(string $accountToken)
    {
        return DB::table('snapshot')
            ->join('account', 'snapshot.account_id', '=', 'account.id')
            ->where('account.token', $accountToken)
            ->get();
    }
}
