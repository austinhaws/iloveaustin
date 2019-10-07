<?php
namespace ILoveAustin\Context;

use ILoveAustin\Service\AccountService;
use ILoveAustin\Service\SnapshotService;

class Services
{
	/** @var AccountService */
	public $account;
	/** @var SnapshotService */
	public $snapshot;

	public function __construct(Context $context)
	{
		$this->account = new AccountService($context);
		$this->snapshot = new SnapshotService($context);
	}
}
