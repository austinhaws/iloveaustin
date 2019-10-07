<?php

namespace ILoveAustin\DAO;

use DB;

class SavingsDao
{
	public function selectSavingsByAccountId($accountId)
	{
		return DB::query("SELECT * FROM savings WHERE account_id = %i", $accountId);
	}
}
