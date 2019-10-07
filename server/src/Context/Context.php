<?php
namespace ILoveAustin\Context;

class Context
{

	/** @var Services */
	public $services;

	/** @var Daos */
	public $daos;

	public function __construct()
	{

		$this->services = new Services($this);
		$this->daos = new Daos($this);
	}
}
