<?php
namespace ILoveAustin\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use ILoveAustin\Types;

class SavingsType extends ObjectType
{
	private static $fieldConversion = [
		'amountGoal' => 'amt_goal',
		'amountCurrent' => 'amt_current',
		'dueDate' => 'due_date',
	];

    public function __construct()
    {
        $config = [
            'name' => 'Savings',
            'description' => 'Savings goals',
            'fields' => function() {
                return [
                    'id' => Types::id(),
					'amountGoal' => Types::string(),
					'amountCurrent' => Types::string(),
					'name' => Types::string(),
					'dueDate' => Types::string(),
					'notes' => Types::string(),
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
