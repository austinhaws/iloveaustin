<?php
namespace ILoveAustin\Type\Input;

use ILoveAustin\Types;

class SavingsInputType extends BaseInputType
{
    public function __construct()
    {
    	parent::__construct([
			self::NAME => 'Savings Input',
			self::DESCRIPTION => 'Savings data',
			self::FIELDS => function() {
				return [
					'id' => Types::id(),
					'amountGoal' => Types::string(),
					'amountCurrent' => Types::string(),
					'name' => Types::string(),
					// todo: use ISO dates by adding a Types::date()
					'dueDate' => Types::string(),
					'notes' => Types::string(),
				];
			},
			self::FIELD_CONVERSIONS => [
				'amountGoal' => 'amt_goal',
				'amountCurrent' => 'amt_current',
				'dueDate' => 'due_date',
			],
		]);
    }
}
