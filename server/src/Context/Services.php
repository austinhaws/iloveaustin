<?php
namespace ILoveAustin\Context;

use ILoveAustin\Service\AccountService;
use ILoveAustin\Service\MonthlyService;
use ILoveAustin\Service\PeriodService;
use ILoveAustin\Service\SavingsService;
use ILoveAustin\Service\SecurityService;
use ILoveAustin\Service\SnapshotService;

class Services
{
	/** @var AccountService */
	public $account;
	/** @var MonthlyService */
	public $monthly;
	/** @var PeriodService */
	public $period;
	/** @var SecurityService */
	public $security;
	/** @var SnapshotService */
	public $snapshot;
	/** @var SavingsService */
	public $savings;

	public function __construct(Context $context)
	{
		$this->account = new AccountService($context);
		$this->monthly = new MonthlyService($context);
		$this->period = new PeriodService($context);
		$this->security = new SecurityService($context);
		$this->snapshot = new SnapshotService($context);
		$this->savings = new SavingsService($context);
	}
}
