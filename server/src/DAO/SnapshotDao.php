<?php
namespace ILoveAustin\DAO;

use DB;

class SnapshotDao
{
	public function selectSnapshotsByAccountId($accountId)
	{
		return DB::query("SELECT * FROM snapshot WHERE account_id = %i ORDER BY name", $accountId);
	}

	public function saveSnapshot(array $snapshot)
	{
		$snapshot['is_totalable'] = $snapshot['is_totalable'] ? 1 : 0;
		$snapshot['notes'] = $snapshot['notes'] ?? '';
		DB::insertUpdate('snapshot', $snapshot);
		if (!isset($snapshot['id'])) {
			$snapshot['id'] = DB::insertId();
		}
		return $snapshot;
	}

	public function deleteSnapshot(int $snapshotId)
	{
		DB::delete('snapshot', 'id=%i', $snapshotId);
	}

	public function selectSnapshotById(int $id)
	{
		return DB::queryFirstRow("SELECT * FROM snapshot WHERE id = %i", $id);
	}
}
