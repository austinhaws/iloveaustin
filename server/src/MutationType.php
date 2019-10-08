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
            ],

            'resolveField' => function($rootValue, $args, $context, ResolveInfo $info) {
        	// todo: remove this? no mutation ever calls it?
exit('If this never gets called then remove it!');
                return $this->{$info->fieldName}($rootValue, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }

    public function saveMonthly($rootValue, $args)
	{
		return $this->context->services->monthly->selectMonthlies($rootValue, $args)[0];
	}
}
