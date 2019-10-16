<?php
namespace ILoveAustin\Type\Type;

use GraphQL\Deferred;
use ILoveAustin\Context\Context;
use ILoveAustin\Types;

class PeriodType extends BaseType
{
    public function __construct()
    {
    	parent::__construct([
			self::NAME => 'Period',
			self::DESCRIPTION => 'Period data',
			self::FIELDS => function() {
				return [
					'previousPeriod' => Types::string(),
					'period' => Types::string(),
					'nextPeriod' => Types::string(),
					'monthlies' => Types::listOf(Types::monthly()),
				];
			},
			self::FIELD_CONVERSIONS => [],
		]);
    }

	protected function resolveMonthlies($period)
	{
		Context::$instance->dataLoaders->periodMonthlies->addParentId($period['period']);

		return new Deferred(function () use ($period) {
			Context::$instance->dataLoaders->periodMonthlies->loadBuffered();
			return Context::$instance->dataLoaders->periodMonthlies->getChildByParentId($period['period']);
		});
	}

}
