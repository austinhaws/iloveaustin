<?php
namespace ILoveAustin\Context;

use ILoveAustin\Type\DataLoader\PeriodMonthliesDataLoader;

class DataLoaders
{
	/** @var PeriodMonthliesDataLoader */
	public $periodMonthlies;

	public function __construct(Context $context)
	{
		$this->periodMonthlies = new PeriodMonthliesDataLoader($context);
	}
}
