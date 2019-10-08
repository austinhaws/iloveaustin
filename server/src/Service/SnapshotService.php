<?php
namespace ILoveAustin\Service;

class SnapshotService extends BaseService
{
	public function selectSnapshots($rootValue, $args)
	{
		//todo get currently logged in user (from token passed in token?) and get the account id from that
		return $this->context->daos->snapshot->selectSnapshotsByAccountId(2);
	}

	public function saveSnapshot($rootValue, $args, array $snapshot)
	{
		// todo: if has id then unset account_id - make sure that unset account_id doesn't update to null
		// todo: if no id then set to current account id
		$snapshot['account_id'] = 2;
		return $this->context->daos->snapshot->saveSnapshot($snapshot);
	}

	public function deleteSnapshot($rootValue, $args, int $snapshotId)
	{
		// todo: select monthly and make sure the account id is the current account id
		$this->context->daos->snapshot->deleteSnapshot($snapshotId);
		return $snapshotId;
	}
}
