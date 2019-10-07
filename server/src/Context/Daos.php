<?php
namespace ILoveAustin\Context;

use ILoveAustin\DAO\AccountDao;
use ILoveAustin\DAO\SavingsDao;
use ILoveAustin\DAO\SnapshotDao;

class Daos
{
	/** @var AccountDao  */
	public $account;
	/** @var SavingsDao  */
	public $savings;
	/** @var SnapshotDao  */
	public $snapshot;

	public function __construct(Context $context)
	{
		$this->account = new AccountDao();
		$this->savings = new SavingsDao();
		$this->snapshot = new SnapshotDao();
	}
}
