<?php

namespace ILoveAustin\DAO;

use DB;

class SavingsDao
{
	public function selectSavingsByAccountId($accountId)
	{
		return DB::query("SELECT * FROM savings WHERE account_id = %i", $accountId);
	}

	public function saveSavings(array $savings)
	{
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
