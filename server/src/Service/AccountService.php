<?php
namespace ILoveAustin\Service;

class AccountService extends BaseService
{
	public function selectAccounts($rootValue, $args)
	{
		return $this->context->daos->account->selectAccounts();
	}

	public function login($rootValue, $args)
	{
		return $this->context->services->security->getAccountIdFromGoogleHeader($rootValue, $args);
	}
}
