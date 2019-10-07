<?php
namespace ILoveAustin\Context;

use ILoveAustin\DAO\AccountDao;
use ILoveAustin\DAO\SnapshotDao;

class Daos
{
	/** @var AccountDao  */
	public $account;
	/** @var SnapshotDao  */
	public $snapshot;

	public function __construct(Context $context)
	{
		$this->account = new AccountDao();
		$this->snapshot = new SnapshotDao();
	}
}
