<?php

namespace App\Http\Controllers\ILoveAustin\Dao;

use App\Http\Controllers\ILoveAustin\Models\Account;
use Illuminate\Support\Facades\DB;

class AccountDao extends BaseDao
{

    public function selectAccountByUsername(string $username)
    {
        $record = DB::table('account')
            ->where('username', $username)
            ->first();

        $account = $record ? new Account() : null;
        if ($record) {
            $account->id = $record->id;
            $account->username = $record->username;
        }

        return $account;
    }

    public function updateAccountToken(int $accountId, string $token)
    {
        DB::table('account')
            ->where('id', $accountId)
            ->update(['token' => $token]);
    }

    public function selectAccountIdForToken(string $accountToken)
    {
        return DB::table('account')
            ->select('id')
            ->where('token', $accountToken)
            ->first();
    }
}
