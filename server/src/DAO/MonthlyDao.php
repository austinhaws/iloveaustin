<?php
namespace ILoveAustin\DAO;

use DB;

class MonthlyDao
{
	public function selectMonthliesForAccountIdPeriod(int $accountId, string $period)
	{
		return DB::query("SELECT * FROM monthly WHERE account_id = %i AND period = %s", $accountId, $period);
	}
}
