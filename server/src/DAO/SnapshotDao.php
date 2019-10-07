<?php
namespace ILoveAustin\DAO;

use DB;

class SnapshotDao
{
	public function selectSnapshotsByAccountId($accountId)
	{
		return DB::query("SELECT * FROM snapshot WHERE account_id = %i", $accountId);
	}
}
