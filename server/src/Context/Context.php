<?php

namespace ILoveAustin\Context;

class Context
{
	/** @var Daos */
	public $daos;
	/** @var Services */
	public $services;

	public function __construct()
	{
		$this->daos = new Daos($this);
		$this->services = new Services($this);
	}
}
