<?php
namespace ILoveAustin\Service;

class MonthlyService extends BaseService
{
	public function selectMonthlies($rootValue, $args)
	{
		return $this->context->daos->monthly->selectMonthliesForAccountIdPeriod($this->context->getAccount()->id, $args['period']);
	}

	public function saveMonthly($rootValue, $args, $monthly)
	{
		// todo: if has id then unset account_id - make sure that unset account_id doesn't update to null
		// todo: if no id then set to current account id
		$monthly['account_id'] = 2;
		return $this->context->daos->monthly->saveMonthly($monthly);
	}

	public function deleteMonthly($rootValue, $args, $monthlyId)
	{
		// todo: select monthly and make sure the account id is the current account id
		$this->context->daos->monthly->deleteMonthly($monthlyId);
		return $monthlyId;
	}
}
