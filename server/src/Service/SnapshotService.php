<?php
namespace ILoveAustin\Service;

use ILoveAustin\Exception\SecurityException;

class SnapshotService extends BaseService
{
	public function selectSnapshots($rootValue, $args)
	{
		return $this->context->daos->snapshot->selectSnapshotsByAccountId($this->context->services->security->getAccount()->id);
	}

	public function saveSnapshot($rootValue, $args, array $snapshot)
	{
		if (isset($snapshot['id'])) {
			$this->testSnapshotBelongsToAccount($snapshot['id']);
		}
		$snapshot['account_id'] = $this->context->services->security->getAccount()->id;
		return $this->context->daos->snapshot->saveSnapshot($snapshot);
	}

	public function deleteSnapshot($rootValue, $args, int $snapshotId)
	{
		$this->testSnapshotBelongsToAccount($snapshotId);
		$this->context->daos->snapshot->deleteSnapshot($snapshotId);
		return $snapshotId;
	}

	private function testSnapshotBelongsToAccount(int $snapshotId)
	{
		$account = $this->context->services->security->getAccount();
		$oldSnapshot = $this->context->daos->snapshot->selectSnapshotById($snapshotId);
		if ($oldSnapshot['account_id'] !== $account->id) {
			throw new SecurityException('Snapshot does not belong to this account');
		}
	}

}
