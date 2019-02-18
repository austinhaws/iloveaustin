<?php

namespace App\Http\Controllers\ILoveAustin\Dao;

use Illuminate\Support\Facades\DB;

class MonthlyDao extends BaseDao
{

    public function selectMonthliesByToken(string $accountToken, string $period)
    {
        return DB::table('monthly')
            ->select('monthly.*')
            ->join('account', 'monthly.account_id', '=', 'account.id')
            ->where('account.token', $accountToken)
            ->where('monthly.period', $period)
            ->get();
    }

    // public function deleteSnapshotById(int $snapshotId, string $accountToken)
    // {
    //     $accountId = $this->daos->account->selectAccountIdForToken($accountToken)->id;
    //     DB::table('snapshot')
    //         ->where('account_id', $accountId)
    //         ->where('id', $snapshotId)
    //         ->delete();
    // }
    //
    // public function save(Snapshot $snapshot, string $accountToken)
    // {
    //     $accountId = $this->daos->account->selectAccountIdForToken($accountToken)->id;
    //     if ($snapshot->id) {
    //         DB::table('snapshot')
    //             ->where('id', $snapshot->id)
    //             ->where('account_id', $accountId)
    //             ->update([
    //                 'name' => $snapshot->name,
    //                 'notes' => $snapshot->notes,
    //                 'amt_goal' => $snapshot->goal,
    //                 'amt_current' => $snapshot->current,
    //                 'is_totalable' => $snapshot->isTotalable,
    //             ]);
    //     } else {
    //         DB::table('snapshot')
    //             ->insert([
    //                 'account_id' => $accountId,
    //                 'name' => $snapshot->name,
    //                 'notes' => $snapshot->notes,
    //                 'amt_goal' => $snapshot->goal,
    //                 'amt_current' => $snapshot->current,
    //                 'is_totalable' => $snapshot->isTotalable,
    //             ]);
    //     }
    // }
}
