<?php
namespace ILoveAustin\DAO;

use DB;

class AccountDao
{
	public function selectAccountById($accountId)
	{
		return DB::queryFirstRow("SELECT * FROM account WHERE id = %i", $accountId);
	}

	public function selectAccounts()
	{
		return DB::query("SELECT * FROM account");
	}
}
