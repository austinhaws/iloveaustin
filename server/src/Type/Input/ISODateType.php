<?php

declare(strict_types=1);

namespace ILoveAustin\Type\Input;

use DateTime;
use DateTimeInterface;
use Exception;
use GraphQL\Error\Error;
use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;

class ISODateType extends ScalarType
{
	/** @var string */
	public $name = 'ISODate';

	/** @var string */
	public $description = 'string output of an ISO Date';

	/**
	 * @param mixed $date
	 * @return false|mixed|string|null
	 */
	public function serialize($date)
	{
		return $date ? $date->format(DateTimeInterface::ISO8601) : null;
	}

	/**
	 * @param mixed $value
	 *
	 * @return string
	 *
	 * @throws Error
	 */
	public function parseValue($value)
	{
		return DateTime::createFromFormat(DateTimeInterface::ISO8601, $value);
	}

	/**
	 * @param Node         $valueNode
	 * @param mixed[]|null $variables
	 *
	 * @return string|null
	 *
	 * @throws Exception
	 */
	public function parseLiteral($valueNode, ?array $variables = null)
	{
		if ($valueNode instanceof StringValueNode) {
			return $this->parseValue($valueNode->value);
		}

		// Intentionally without message, as all information already in wrapped Exception
		throw new Exception();
	}
}
