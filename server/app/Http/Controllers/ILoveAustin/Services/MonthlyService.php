<?php

namespace App\Http\Controllers\ILoveAustin\Services;

class MonthlyService extends BaseService
{
    public function selectMonthlies(string $accountToken, string $period)
    {
        return $this->daos->monthly->selectMonthliesByToken($accountToken, $period);
    }

    // public function deleteSnapshot(int $snapshotId, string $accountToken)
    // {
    //     $this->daos->snapshot->deleteSnapshotById($snapshotId, $accountToken);
    // }
    //
    // public function saveSnapshot(Snapshot $snapshot, string $accountToken)
    // {
    //     $this->daos->snapshot->save($snapshot, $accountToken);
    // }
}
