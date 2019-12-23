<?php

namespace ILoveAustin\DAO;

use DB;

class SavingsDao
{
	public function selectSavingsByAccountId($accountId)
	{
		return DB::query("SELECT * FROM savings WHERE account_id = %i ORDER BY name", $accountId);
	}

	public function selectSavingsById($savingsId)
	{
		return DB::queryFirstRow("SELECT * FROM savings WHERE id = %i", $savingsId);
	}

	public function saveSavings(array $savings)
	{
		$savings['due_date'] = $savings['due_date'] ?? '';
		$savings['notes'] = $savings['notes'] ?? '';
		DB::insertUpdate('savings', $savings);
		if (!isset($savings['id'])) {
			$savings['id'] = DB::insertId();
		}
		return $savings;
	}

	public function deleteSavings(int $savingsId)
	{
		DB::delete('savings', 'id=%i', $savingsId);
	}
}
