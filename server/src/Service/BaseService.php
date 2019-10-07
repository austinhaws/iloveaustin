<?php
namespace ILoveAustin\Service;

use ILoveAustin\Context\Context;

class BaseService
{
	/** @var Context */
	protected $context;

	public function __construct(Context $context)
	{
		$this->context = $context;
	}
}
