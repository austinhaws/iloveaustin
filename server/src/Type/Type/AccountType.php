<?php
namespace ILoveAustin\Type\Type;

use ILoveAustin\Types;

class AccountType extends BaseType
{
	public function __construct()
    {
        parent::__construct([
			self::NAME => 'Account',
			self::DESCRIPTION => 'Logged in user account',
			self::FIELDS => function() {
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
			self::FIELD_CONVERSIONS => [
				'receiveEmails' => 'receive_emails',
				'weeksRemaining' => 'weeks_remaining',
				'lastBackup' => 'last_backup',
			],
		]);
    }
}
