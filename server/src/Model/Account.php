<?php
namespace ILoveAustin\Model;

class Account extends BaseModel
{
	/** @var int */
	public $id;
	/** @var string */
	public $openid;
	/** @var string */
	public $role;
	/** @var string */
	public $email;
	/** @var string */
	public $nickname;
	/** @var string */
	public $receive_emails;
	/** @var string */
	public $username;
	/** @var string */
	public $password;
	/** @var string */
	public $weeks_remaining;
	/** @var string */
	public $last_backup;
	/** @var string */
	public $google_sub;
}
