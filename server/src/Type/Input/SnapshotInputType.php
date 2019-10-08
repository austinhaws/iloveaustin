<?php
namespace ILoveAustin\Type\Input;

use ILoveAustin\Types;

class SnapshotInputType extends BaseInputType
{
    public function __construct()
    {
    	parent::__construct([
			self::NAME => 'Snapshot Input',
			self::DESCRIPTION => 'Snapshot data',
			self::FIELDS => function() {
				return [
					'id' => Types::id(),
					'name' => Types::string(),
					'notes' => Types::string(),
					'amountGoal' => Types::string(),
					'amountCurrent' => Types::string(),
					'isTotalable' => Types::int(),
				];
			},
			self::FIELD_CONVERSIONS => [
				'amountGoal' => 'amt_goal',
				'amountCurrent' => 'amt_current',
				'isTotalable' => 'is_totalable',
			],
		]);
    }
}
