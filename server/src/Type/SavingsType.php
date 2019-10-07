<?php
namespace ILoveAustin\Type;

use ILoveAustin\Types;

class SavingsType extends BaseType
{
    public function __construct()
    {
        parent::__construct([
			self::NAME => 'Savings',
			self::DESCRIPTION => 'Savings goals',
			self::FIELDS => function() {
				return [
					'id' => Types::id(),
					'amountGoal' => Types::string(),
					'amountCurrent' => Types::string(),
					'name' => Types::string(),
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
