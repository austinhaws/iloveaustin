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

	public function selectAccountByGoogleId(string $googleAccountId)
	{
		return DB::queryFirstRow("SELECT * FROM account WHERE google_sub = %s", $googleAccountId);
	}

	public function saveAccount(array $account)
	{
		DB::insertUpdate('account', $account);
		if (!isset($account['id'])) {
			$account['id'] = DB::insertId();
		}
		return $account;
	}
}
