<?php
namespace ILoveAustin\Type\Input;

use ILoveAustin\Types;

class PeriodInputType extends BaseInputType
{
    public function __construct()
    {
    	parent::__construct([
			self::NAME => 'Period Input',
			self::DESCRIPTION => 'Period data',
			self::FIELDS => function() {
				return [
					'period' => Types::string(),
				];
			},
			self::FIELD_CONVERSIONS => [
			],
		]);
    }
}
