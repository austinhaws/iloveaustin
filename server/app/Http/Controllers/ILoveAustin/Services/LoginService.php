<?php

namespace App\Http\Controllers\ILoveAustin\Services;

class LoginService extends BaseService
{
    public function login(\Illuminate\Http\Request $request, string $username)
    {
        $account = $this->daos->account->selectAccountByUsername($username);

        $token = '';
        if ($account) {
            $token = uniqid();
            $this->daos->account->updateAccountToken($account->id, $token);
        }

        return response()->json($token);
    }
}
