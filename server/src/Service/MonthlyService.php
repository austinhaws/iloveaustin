<?php
namespace ILoveAustin\Service;

use ILoveAustin\Exception\SecurityException;
use ILoveAustin\Types;

class MonthlyService extends BaseService
{
	public function selectMonthlies($rootValue, $args)
	{
		return $this->context->daos->monthly->selectMonthliesForAccountIdPeriod($this->context->getAccount()->id, $args['period']);
	}

	public function saveMonthly($rootValue, $args)
	{
		$account = $this->context->getAccount();

		$monthly = Types::monthlyInput()->convertFieldsToDB($args['monthly']);
		if (isset($monthly['id'])) {
			$this->testMonthlyBelongsToAccount($monthly['id']);
		}
		// they can't ever pass in accountId, it's not in the MonthlyInputType
		$monthly['account_id'] = $account->id;
		return $this->context->daos->monthly->saveMonthly($monthly);
	}

	public function deleteMonthly($rootValue, $args)
	{
		$monthlyId = $args['id'];

		$this->testMonthlyBelongsToAccount($monthlyId);

		$this->context->daos->monthly->deleteMonthly($monthlyId);
		return $monthlyId;
	}

	/**
	 * @param int $monthlyId
	 */
	private function testMonthlyBelongsToAccount($monthlyId)
	{
		$account = $this->context->getAccount();
		$oldMonthly = $this->context->daos->monthly->selectMonthlyById($monthlyId);
		if ($oldMonthly['account_id'] !== $account->id) {
			throw new SecurityException('Monthly does not belong to this account');
		}
	}
}
