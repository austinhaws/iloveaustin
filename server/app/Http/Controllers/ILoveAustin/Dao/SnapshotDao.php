<?php

namespace App\Http\Controllers\ILoveAustin\Dao;

use Illuminate\Support\Facades\DB;

class SnapshotDao extends BaseDao
{

    public function selectSnapshotsByToken(string $accountToken)
    {
        return DB::table('snapshot')
            ->select('snapshot.*')
            ->join('account', 'snapshot.account_id', '=', 'account.id')
            ->where('account.token', $accountToken)
            ->get();
    }

    public function deleteSnapshotById(int $snapshotId, string $accountToken)
    {
        $accountId = $this->daos->account->selectAccountIdForToken($accountToken)->id;
        DB::table('snapshot')
            ->where('account_id', $accountId)
            ->where('id', $snapshotId)
            ->delete();
    }
}
