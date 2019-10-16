<?php
namespace ILoveAustin\Type\DataLoader;


class PeriodMonthliesDataLoader extends BaseDataLoader
{

	public function loadBuffered()
	{
		if (count($this->buffer) === 0) {
			$monthlies = $this->context->services->monthly->selectMonthliesForPeriods($this->parentIds);
			$this->buffer = array_reduce($monthlies, function ($carry, $monthly) {
				if (!isset($carry[$monthly['period']])) {
					$carry[$monthly['period']] = [];
				}
				$carry[$monthly['period']][] = $monthly;
				return $carry;
			}, []);
		}
	}
}
