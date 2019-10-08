<?php
namespace ILoveAustin;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
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
						return $this->context->services->monthly->deleteMonthly($rootValue, $args, $args['id']);
					},
				],
				'saveMonthly' => [
					'type' => Types::monthly(),
					'args' => [
						'monthly' => ['type' => Types::monthlyInput()],
					],
					'resolve' => function ($rootValue, $args) {
						return $this->context->services->monthly->saveMonthly($rootValue, $args, Types::monthlyInput()->convertFieldsToDB($args['monthly']));
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

            'resolveField' => function($rootValue, $args, $context, ResolveInfo $info) {
        	// todo: remove this? no mutation ever calls it?
exit('If this never gets called then remove it!');
                return $this->{$info->fieldName}($rootValue, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }
}
