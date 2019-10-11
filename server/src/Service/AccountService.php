<?php
namespace ILoveAustin\Service;

use Google_Client;

class AccountService extends BaseService
{
	public function selectAccounts($rootValue, $args)
	{
		return $this->context->daos->account->selectAccounts();
	}

	public function login($rootValue, $args)
	{
		$client = new Google_Client();
		$client->setAuthConfig(dirname(__DIR__).'/Resources/client_secret.json');
		$client->setAccessType('offline');
		$client->setApprovalPrompt("consent");
		$client->setIncludeGrantedScopes(true);

		$token = $client->verifyIdToken($args['authorization']);
		$googleAccountId = $token['sub'];

		$account = $this->context->daos->account->selectAccountByGoogleId($googleAccountId);
		if (!$account) {
			$account = [
				'email' => $token['email'],
				'nickname' => $token['name'],
				'google_sub' => $token['sub'],
			];
			$this->context->daos->account->saveAccount($account);
			$account = $this->context->daos->account->selectAccountByGoogleId($googleAccountId);
		}
		return $account;
	}
}
