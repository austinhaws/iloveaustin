<?php
namespace ILoveAustin\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use ILoveAustin\Types;

class SnapshotType extends ObjectType
{
	private static $fieldConversion = [
		'accountId' => 'account_id',
		'amountGoal' => 'amt_goal',
		'amountCurrent' => 'amt_current',
		'isTotalable' => 'is_totalable',
	];

    public function __construct()
    {
        $config = [
            'name' => 'Snapshot',
            'description' => 'Snapshots for goals',
            'fields' => function() {
                return [
                    'id' => Types::id(),
                    'accountId' => Types::id(),
					'name' => Types::string(),
					'notes' => Types::string(),
					'amountGoal' => Types::int(),
					'amountCurrent' => Types::int(),
					'isTotalable' => Types::int(),
                ];
            },
            'interfaces' => [
                Types::node()
            ],
            'resolveField' => function($record, $args, $context, ResolveInfo $info) {
                $method = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($record, $args, $context, $info);
                } else {
                    return $record[self::$fieldConversion[$info->fieldName] ?? $info->fieldName];
                }
            }
        ];
        parent::__construct($config);
    }
}
