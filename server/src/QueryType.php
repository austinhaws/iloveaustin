<?php
namespace ILoveAustin;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use ILoveAustin\Context\Context;

class QueryType extends ObjectType
{
	/** @var Context */
	private $context;

    public function __construct(Context $context)
    {
		$this->context = $context;

        $config = [
            'name' => 'Query',
            'fields' => [
            	'accounts' => [
            		'type' => Types::listOf(Types::account()),
					'description' => 'Returns accounts',
					'args' => [],
				],
				'monthlies' => [
					'type' => Types::listOf(Types::monthly()),
					'description' => 'Returns account monthly',
					'args' => [
						'period' => Types::nonNull(Types::string())
					],
				],
				'period' => [
					'type' => Types::nonNull(Types::period()),
					'description' => 'Returns monthlies for a period',
					'args' => [
						'period' => Types::string(),
					],
				],
				'getPreviousPeriod' => [
					'type' => Types::nonNull(Types::period()),
					'description' => 'Returns monthlies for the previous period',
					'args' => [
						'period' => Types::string(),
					],
				],
				'savings' => [
					'type' => Types::listOf(Types::savings()),
					'description' => 'Returns account savings',
					'args' => [],
				],
				'snapshots' => [
					'type' => Types::listOf(Types::snapshot()),
					'description' => 'Returns account snapshots',
					'args' => [],
				],
            ],
            'resolveField' => function($rootValue, $args, $context, ResolveInfo $info) {
                return $this->{$info->fieldName}($rootValue, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }

    public function accounts($rootValue, $args)
	{
		return $this->context->services->account->selectAccounts($rootValue, $args);
	}

    public function monthlies($rootValue, $args)
	{
		return $this->context->services->monthly->selectMonthlies($rootValue, $args);
	}

	public function period($rootValue, $args)
	{
		return $this->context->services->period->getPeriod($rootValue, $args);
	}

	public function getPreviousPeriod($rootValue, $args)
	{
		return $this->context->services->period->getPreviousPeriod($rootValue, $args);
	}

    public function savings($rootValue, $args)
	{
		return $this->context->services->savings->selectSavings($rootValue, $args);
	}

    public function snapshots($rootValue, $args)
	{
		return $this->context->services->snapshot->selectSnapshots($rootValue, $args);
	}
}
