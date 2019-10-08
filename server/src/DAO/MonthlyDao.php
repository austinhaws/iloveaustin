<?php
namespace ILoveAustin\DAO;

use DB;

class MonthlyDao
{
	public function selectMonthliesForAccountIdPeriod(int $accountId, string $period)
	{
		return DB::query("SELECT * FROM monthly WHERE account_id = %i AND period = %s", $accountId, $period);
	}

	public function saveMonthly(array $monthly)
	{
		DB::insertUpdate('monthly', $monthly);
		if (!isset($monthly['id'])) {
			$monthly['id'] = DB::insertId();
		}
		return $monthly;
	}

	public function deleteMonthly(int $monthlyId)
	{
		DB::delete('monthly', 'id=%i', $monthlyId);
	}
}
