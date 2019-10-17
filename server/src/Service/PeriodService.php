<?php
namespace ILoveAustin\Service;

class PeriodService extends BaseService
{
	public function getPeriod($rootValue, $args)
	{
		if (isset($args['period'])) {
			$period = $args['period'];
		} else {
			$period = date('n/Y');
		}
		return [
			'previousPeriod' => $this->movePeriod($period, -1),
			'period' => $period,
			'nextPeriod' => $this->movePeriod($period, 1),
		];
	}

	public function getNextPeriod($rootValue, $args)
	{
		$period = $args['period'];
		$nextPeriod = $this->movePeriod($period, 1);
		$result = $this->getPeriod($rootValue, ['period' => $nextPeriod]);

		if ((!$result['monthlies']) && $args['copyForward']) {
			$this->context->daos->monthly->copyForwardMonthliesForAccountIdPeriod($this->context->services->security->getAccount()->id, $period, $nextPeriod);
			$result = $this->getPeriod($rootValue, ['period' => $nextPeriod]);
		}

		return $result;
	}

	public function getPreviousPeriod($rootValue, $args)
	{
		return $this->getPeriod($rootValue, ['period' => $this->movePeriod($args['period'], -1)]);
	}

	/**
	 * @param string $period
	 * @param int $deltaMonths
	 * @return string
	 */
	private function movePeriod(string $period, int $deltaMonths)
	{
		$pieces = array_map(function ($piece) {
			return intval($piece);
		}, explode('/', $period));

		$pieces[0] += $deltaMonths;
		if ($pieces[0] < 1) {
			$pieces[0] = 12;
			$pieces[1]--;
		} else if ($pieces[0] > 12) {
			$pieces[0] = 1;
			$pieces[1]++;
		}
		return join('/', [str_pad($pieces[0], 2, '0', STR_PAD_LEFT), count($pieces) > 1 ? $pieces[1] : '']);
	}
}
