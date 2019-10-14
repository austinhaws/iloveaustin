<?php
namespace ILoveAustin\Service;

class SecurityService extends BaseService
{
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
