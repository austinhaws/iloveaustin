<?php

namespace App\Http\Controllers\ILoveAustin\Services;

use App\Http\Controllers\ILoveAustin\Models\Snapshot;

class SnapshotService extends BaseService
{
    public function selectSnapshots(string $accountToken)
    {
        return $this->daos->snapshot->selectSnapshotsByToken($accountToken);
    }

    public function deleteSnapshot(int $snapshotId, string $accountToken)
    {
        $this->daos->snapshot->deleteSnapshotById($snapshotId, $accountToken);
    }

    public function saveSnapshot(Snapshot $snapshot, string $accountToken)
    {
        $this->daos->snapshot->save($snapshot, $accountToken);
    }
}
