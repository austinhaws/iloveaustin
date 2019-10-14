<?php
namespace ILoveAustin;

use GraphQL\Type\Definition\ObjectType;
use ILoveAustin\Context\Context;

class MutationType extends ObjectType
{
	/** @var Context */
	private $context;

    public function __construct(Context $context)
    {
		$this->context = $context;

        $config = [
            'name' => 'Mutation',
            'fields' => [
            	// ---- Monthly ---- //
            	'deleteMonthly' => [
					'type' => Types::id(),
					'args' => [
						'id' => ['type' => Types::nonNull(Types::id())],
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->monthly->deleteMonthly($rootValue, $args);
					},
				],
				'login' => [
					'type' => Types::account(),
					'args' => [
						'Authorization' => Types::nonNull(Types::string()),
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->account->login($rootValue, $args);
					},
				],
				'saveMonthly' => [
					'type' => Types::monthly(),
					'args' => [
						'monthly' => ['type' => Types::monthlyInput()],
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->monthly->saveMonthly($rootValue, $args);
					},
				],

				// ---- Period ---- //
				'getNextPeriod' => [
					'type' => Types::period(),
					'args' => [
						'period' => ['type' => Types::nonNull(Types::string())],
						'copyForward' => ['type' => Types::nonNull(Types::boolean())],
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->period->getNextPeriod($rootValue, $args);
					},
				],

				// ---- Savings ---- //
				'deleteSavings' => [
					'type' => Types::id(),
					'args' => [
						'id' => ['type' => Types::nonNull(Types::id())],
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->savings->deleteSavings($rootValue, $args, $args['id']);
					},
				],
				'saveSavings' => [
					'type' => Types::savings(),
					'args' => [
						'savings' => ['type' => Types::savingsInput()],
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->savings->saveSavings($rootValue, $args, Types::savingsInput()->convertFieldsToDB($args['savings']));
					},
				],

				// ---- Snapshot ---- //
				'deleteSnapshot' => [
					'type' => Types::id(),
					'args' => [
						'id' => ['type' => Types::nonNull(Types::id())],
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->snapshot->deleteSnapshot($rootValue, $args, $args['id']);
					},
				],
				'saveSnapshot' => [
					'type' => Types::snapshot(),
					'args' => [
						'snapshot' => ['type' => Types::snapshotInput()],
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->snapshot->saveSnapshot($rootValue, $args, Types::snapshotInput()->convertFieldsToDB($args['snapshot']));
					},
				],
            ],
		];
        parent::__construct($config);
    }
}
