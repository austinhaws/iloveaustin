<?php
namespace ILoveAustin\Service;

class MonthlyService extends BaseService
{
	public function selectMonthlies($rootValue, $args)
	{
		// todo: use logged in account id
		// todo: use passed arg period
		return $this->context->daos->monthly->selectMonthliesForAccountIdPeriod(2, '10/2010');
	}
}
