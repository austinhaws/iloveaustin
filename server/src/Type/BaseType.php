<?php
namespace ILoveAustin\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use ILoveAustin\Types;

abstract class BaseType extends ObjectType
{
	protected const DESCRIPTION = 'description';
	protected const FIELDS = 'fields';
	protected const FIELD_CONVERSIONS = 'fieldConversions';
	protected const INTERFACES = 'interfaces';
	protected const NAME = 'name';
	protected const RESOLVE = 'resolve';
	protected const RESOLVE_FIELD = 'resolveField';

	public function __construct(array $config)
    {
    	$this->config[self::FIELD_CONVERSIONS] = $config[self::FIELD_CONVERSIONS] ?? null;
    	$config[self::INTERFACES] = $config[self::INTERFACES] ?? [Types::node()];

    	$config[self::RESOLVE_FIELD] = function ($record, $args, $context, ResolveInfo $info)
		{
			$method = self::RESOLVE . ucfirst($info->fieldName);
			if (method_exists($this, $method)) {
				return $this->{$method}($record, $args, $context, $info);
			} else {
				return $record[$this->config[self::FIELD_CONVERSIONS][$info->fieldName] ?? $info->fieldName];
			}
		};

        parent::__construct($config);
    }
}
