<?php
namespace ILoveAustin\Type;

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
					'period' => Types::string(),
					'monthlies' => Types::listOf(Types::monthly()),
				];
			},
			self::FIELD_CONVERSIONS => [],
		]);
    }
}
