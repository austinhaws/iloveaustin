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

	public function copyForwardMonthliesForAccountIdPeriod(int $accountId, string $prevPeriod, string $nextPeriod)
	{
		DB::query("
			INSERT INTO monthly (account_id, period, name, notes, amt_goal, amt_spent) 
				SELECT 
					%i account_id,
					%s period,
					name,
					'' notes,
					amt_goal,
					'000' amt_spent
				FROM monthly
				WHERE account_id = %i AND period = %s
		", $accountId, $nextPeriod, $accountId, $prevPeriod);
	}

	public function selectMonthlyById($id)
	{
		return DB::queryFirstRow("SELECT * FROM monthly WHERE id = %i", $id);
	}

	public function selectMonthliesForAccountIdPeriods(int $accountId, array $periods)
	{
		return DB::query("SELECT * FROM monthly WHERE account_id = %i AND period IN %ls", $accountId, $periods);
	}
}
