<?php
namespace ILoveAustin\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use ILoveAustin\Types;

class MonthlyType extends ObjectType
{
	private static $fieldConversion = [
		'amountGoal' => 'amt_goal',
		'amountSpent' => 'amt_spent',
	];

    public function __construct()
    {
        $config = [
            'name' => 'Monthly',
            'description' => 'Monthly data',
            'fields' => function() {
                return [
                    'id' => Types::id(),
					'period' => Types::string(),
					'name' => Types::string(),
					'notes' => Types::string(),
					'amountGoal' => Types::string(),
					'amountSpent' => Types::string(),
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
