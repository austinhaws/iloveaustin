<?php
namespace ILoveAustin\Service;

use ILoveAustin\Model\Account;

class SecurityService extends BaseService
{
	/** @var Account the currently logged in account user based on the google tokenid used in the request */
	private $currentAccount = null;

	/**
	 * @return Account|null
	 */
	public function getAccount()
	{
		if (!$this->currentAccount) {
			// check if maybe on the header it's got account information
			$account = $this->getAccountIdFromGoogleHeader(null, null);
			if ($account) {
				$this->currentAccount = new Account($account);
			}
		}
		return $this->currentAccount;
	}

	public function getAccountIdFromGoogleHeader($rootValue, $args)
	{
		// taken from Authorization parameter or from Authorization header with precedence to parameter for login
		$googleTokenId = $args['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? null;
		$client = new \Google_Client();
		$client->setAuthConfig(dirname(__DIR__).'/Resources/client_secret.json');
		$client->setAccessType('offline');
		$client->setApprovalPrompt("consent");
		$client->setIncludeGrantedScopes(true);

		$token = $client->verifyIdToken($googleTokenId);
		$googleAccountId = $token['sub'];

		// update/insert account information based on google information
		$account = $this->context->daos->account->selectAccountByGoogleId($googleAccountId);
		$accountDB = [
			'email' => $token['email'],
			'nickname' => $token['name'],
			'google_sub' => $token['sub'],
		];
		if ($account) {
			$accountDB['id'] = $account['id'];
		}
		$this->context->daos->account->saveAccount($accountDB);

		return $this->context->daos->account->selectAccountByGoogleId($googleAccountId);
	}
}
