<?php
namespace ILoveAustin\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use ILoveAustin\Types;

class AccountType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Account',
            'description' => 'Logged in user account',
            'fields' => function() {
                return [
                    'id' => Types::id(),
                    'openid' => Types::string(),
					'role' => Types::string(),
					'email' => Types::string(),
					'nickname' => Types::string(),
					'receive_emails' => Types::string(),
					'username' => Types::string(),
					'password' => Types::string(),
					'weeks_remaining' => Types::string(),
					'last_backup' => Types::string(),
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
                    return $record[$info->fieldName];
                }
            }
        ];
        parent::__construct($config);
    }
}
