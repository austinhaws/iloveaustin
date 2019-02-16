<?php

namespace App\Http\Controllers\ILoveAustin\Dao;

use App\Http\Controllers\ILoveAustin\Models\Snapshot;
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

    public function save(Snapshot $snapshot, string $accountToken)
    {
        $accountId = $this->daos->account->selectAccountIdForToken($accountToken)->id;
        DB::table('snapshot')
            ->where('id', $snapshot->id)
            ->where('account_id', $accountId)
            ->update([
                'name' => $snapshot->name,
                'notes' => $snapshot->notes,
                'amt_goal' => $snapshot->goal,
                'amt_current' => $snapshot->current,
                'is_totalable' => $snapshot->isTotalable,
            ]);
    }
}
