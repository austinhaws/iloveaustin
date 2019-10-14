<?php
namespace ILoveAustin\Model;

abstract class BaseModel
{
	public function __construct($array = null)
	{
		if ($array) {
			$this->loadFromArray($array);
		}
	}

	public function loadFromArray($array)
	{
		foreach ($array as $key => $value)
		{
			$this->$key = $value;
		}
	}
}
