<?php
namespace ILoveAustin\Service;

class PeriodService extends BaseService
{
	public function getPeriod($rootValue, $args)
	{
		// todo: use logged in account id
		if (isset($args['period'])) {
			$period = $args['period'];
		} else {
			$period = date('n/Y');
		}
		return [
			'period' => $period,
			// todo: move this to a conditinal select if the fields are requested (GraphQL library should have a way to do this naturally)
			'monthlies' => $this->context->daos->monthly->selectMonthliesForAccountIdPeriod(2, $period),
		];
	}

	public function getNextPeriod($rootValue, $args)
	{
		// todo: use logged in account id
		$period = $args['period'];
		$nextPeriod = $this->movePeriod($period, 1);
		$result = $this->getPeriod($rootValue, ['period' => $nextPeriod]);

		if (!$result['monthlies']) {
			// todo: use logged in account id
			$this->context->daos->monthly->copyForwardMonthliesForAccountIdPeriod(2, $period, $nextPeriod);
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
		return join('/', [str_pad($pieces[0], 2, '0', STR_PAD_LEFT), $pieces[1]]);
	}
}
