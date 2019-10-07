<?php
namespace ILoveAustin\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use ILoveAustin\Types;

class AccountType extends ObjectType
{
	private static $fieldConversion = [
		'receiveEmails' => 'receive_emails',
		'weeksRemaining' => 'weeks_remaining',
		'lastBackup' => 'last_backup',
	];


	public function __construct()
    {
        $config = [
            'name' => 'Account',
            'description' => 'Logged in user account',
            'fields' => function() {
                return [
                    'openid' => Types::string(),
					'role' => Types::string(),
					'email' => Types::string(),
					'nickname' => Types::string(),
					'receiveEmails' => Types::string(),
					'username' => Types::string(),
					'password' => Types::string(),
					'weeksRemaining' => Types::string(),
					'lastBackup' => Types::string(),
					'token' => Types::string(),
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