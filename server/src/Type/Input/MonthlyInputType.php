<?php
namespace ILoveAustin\Type\Input;

use ILoveAustin\Types;

class MonthlyInputType extends BaseInputType
{
    public function __construct()
    {
    	parent::__construct([
			self::NAME => 'Monthly Input',
			self::DESCRIPTION => 'Monthly data',
			self::FIELDS => function() {
				return [
					'id' => Types::id(),
					'period' => Types::string(),
					'name' => Types::string(),
					'notes' => Types::string(),
					'amountGoal' => Types::string(),
					'amountSpent' => Types::string(),
				];
			},
			self::FIELD_CONVERSIONS => [
				'amountGoal' => 'amt_goal',
				'amountSpent' => 'amt_spent',
			],
		]);
    }
}
