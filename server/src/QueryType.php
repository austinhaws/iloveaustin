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
						'copyForward' => ['type' => Types::boolean()],
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

    public function monthlies($rootValue, $args)
	{
		return $this->context->services->monthly->selectMonthlies($rootValue, $args);
	}

	public function period($rootValue, $args)
	{
		$period = $this->context->services->period->getPeriod($rootValue, $args);
		if ($args['copyForward'] ?? false) {
			$monthlies = $this->context->services->monthly->selectMonthlies($rootValue, ['period' => $period['period']]);
			if (!$monthlies) {
				$this->context->services->monthly->copyMonthliesForward($period);
			}
		}
		return $period;
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
