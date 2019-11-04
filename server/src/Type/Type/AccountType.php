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
					// there are more DB fields, but these are the only ones to expose
					'email' => Types::string(),
					'nickname' => Types::string(),
					'lastBackup' => Types::string(),
				];
			},
			self::FIELD_CONVERSIONS => [
				'lastBackup' => 'last_backup',
			],
		]);
    }
}
