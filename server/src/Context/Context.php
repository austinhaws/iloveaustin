<?php

namespace ILoveAustin\Context;

use ILoveAustin\Model\Account;

class Context
{
	/** @var Daos */
	public $daos;
	/** @var Services */
	public $services;
	/** @var Account the currently logged in account user based on the google tokenid used in the request */
	private $currentAccount;

	public function __construct()
	{
		$this->daos = new Daos($this);
		$this->services = new Services($this);
		$this->currentAccount = null;
	}

	/**
	 * @return Account|null
	 */
	public function getAccount()
	{
		if (!$this->currentAccount) {
			// check if maybe on the header it's got account information
			$account = $this->services->security->getAccountIdFromGoogleHeader(null, null);
			if ($account) {
				$this->currentAccount = new Account($account);
			}
		}
		return $this->currentAccount;
	}
}
