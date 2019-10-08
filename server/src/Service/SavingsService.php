<?php

namespace ILoveAustin\Service;

class SavingsService extends BaseService
{
	public function selectSavings($rootValue, $args)
	{
		//todo: use real account id/token from args
		return $this->context->daos->savings->selectSavingsByAccountId(2);
	}

	public function saveSavings($rootValue, $args, array $savings)
	{
		// todo: if has id then unset account_id - make sure that unset account_id doesn't update to null
		// todo: if no id then set to current account id
		$savings['account_id'] = 2;
		return $this->context->daos->savings->saveSavings($savings);
	}

	public function deleteSavings($rootValue, $args, int $savingsId)
	{
		// todo: select record and make sure the account id is the current account id
		$this->context->daos->savings->deleteSavings($savingsId);
		return $savingsId;
	}
}
