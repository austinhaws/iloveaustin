<?php
namespace ILoveAustin\Context;

use ILoveAustin\Service\AccountService;
use ILoveAustin\Service\SavingsService;
use ILoveAustin\Service\SnapshotService;

class Services
{
	/** @var AccountService */
	public $account;
	/** @var SnapshotService */
	public $snapshot;
	/** @var SavingsService */
	public $savings;

	public function __construct(Context $context)
	{
		$this->account = new AccountService($context);
		$this->snapshot = new SnapshotService($context);
		$this->savings = new SavingsService($context);
	}
}
