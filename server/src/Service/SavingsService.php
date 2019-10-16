<?php

namespace ILoveAustin\Service;

use ILoveAustin\Exception\SecurityException;

class SavingsService extends BaseService
{
	public function selectSavings($rootValue, $args)
	{
		return $this->context->daos->savings->selectSavingsByAccountId($this->context->services->security->getAccount()->id);
	}

	public function saveSavings($rootValue, $args, array $savings)
	{
		if (isset($savings['id'])) {
			$this->testSavingsBelongsToAccount($savings['id']);
		}
		$savings['account_id'] = $this->context->services->security->getAccount()->id;
		return $this->context->daos->savings->saveSavings($savings);
	}

	public function deleteSavings($rootValue, $args, int $savingsId)
	{
		$this->testSavingsBelongsToAccount($savingsId);
		$this->context->daos->savings->deleteSavings($savingsId);
		return $savingsId;
	}

	private function testSavingsBelongsToAccount(int $savingsId)
	{
		$account = $this->context->services->security->getAccount();
		$oldSavings = $this->context->daos->savings->selectSavingsById($savingsId);
		if ($oldSavings['account_id'] !== $account->id) {
			throw new SecurityException('Savings does not belong to this account');
		}
	}
}
