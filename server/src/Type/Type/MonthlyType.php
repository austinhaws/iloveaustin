<?php
namespace ILoveAustin\Type\Type;

use ILoveAustin\Types;

class MonthlyType extends BaseType
{
    public function __construct()
    {
    	parent::__construct([
			self::NAME => 'Monthly',
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
