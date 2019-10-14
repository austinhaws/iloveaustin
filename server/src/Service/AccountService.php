<?php
namespace ILoveAustin\Service;

class AccountService extends BaseService
{
	public function login($rootValue, $args)
	{
		return $this->context->services->security->getAccountIdFromGoogleHeader($rootValue, $args);
	}
}
