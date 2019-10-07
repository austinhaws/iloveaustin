<?php
namespace ILoveAustin\Service;

class SnapshotService extends BaseService
{
	public function selectSnapshots($rootValue, $args)
	{
		//todo get currently logged in user (from token passed in token?) and get the account id from that
		return $this->context->daos->snapshot->selectSnapshotsByAccountId(2);
	}
}
