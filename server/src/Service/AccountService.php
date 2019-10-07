<?php
namespace ILoveAustin\Service;

class AccountService extends BaseService
{
	public function selectAccounts($rootValue, $args)
	{
		return $this->context->daos->account->selectAccounts();
	}
}
