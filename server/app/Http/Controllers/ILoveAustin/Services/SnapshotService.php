<?php

namespace App\Http\Controllers\ILoveAustin\Services;

class SnapshotService extends BaseService
{
    public function selectSnapshots(string $accountToken)
    {
        return $this->daos->snapshot->selectSnapshotsByToken($accountToken);
    }

    public function deleteSnapshot(string $accountToken, int $snapshotId)
    {
        $this->daos->snapshot->deleteSnapshotById($snapshotId, $accountToken);
    }
}
