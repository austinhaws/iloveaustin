<?php

namespace ILoveAustin\Service;

class SavingsService extends BaseService
{
	public function selectSavings($rootValue, $args)
	{
		//todo: use real account id/token from args
		return $this->context->daos->savings->selectSavingsByAccountId(2);
	}
}
