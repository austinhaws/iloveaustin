<?php
namespace ILoveAustin\Type\Type;

use ILoveAustin\Types;

class SnapshotType extends BaseType
{
    public function __construct()
    {
        parent::__construct([
			self::NAME => 'Snapshot',
			self::DESCRIPTION => 'Snapshots for goals',
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
