<?php

namespace ILoveAustin\Context;

class Context
{
	/** @var DataLoaders */
	public $dataLoaders;
	/** @var Daos */
	public $daos;
	/** @var Services */
	public $services;

	/** @var Context */
	public static $instance;

	public function __construct()
	{
		$this->dataLoaders = new DataLoaders($this);
		$this->daos = new Daos($this);
		$this->services = new Services($this);

		if (Context::$instance) {
			throw new \RuntimeException('Context already created!');
		}
		Context::$instance = $this;
	}
}
