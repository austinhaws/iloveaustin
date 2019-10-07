<?php
namespace ILoveAustin\Type;

use GraphQL\Examples\Blog\Data\DataSource;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use ILoveAustin\AppContext;
use ILoveAustin\Context\Context;
use ILoveAustin\Types;

class QueryType extends ObjectType
{
	/** @var Context */
	private $context;

    public function __construct()
    {
		$this->context = new Context();

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


//todo dead below here
                'user' => [
                    'type' => Types::user(),
                    'description' => 'Returns user by id (in range of 1-5)',
                    'args' => [
                        'id' => Types::nonNull(Types::id())
                    ]
                ],
                'viewer' => [
                    'type' => Types::user(),
                    'description' => 'Represents currently logged-in user (for the sake of example - simply returns user with id == 1)'
                ],
                'stories' => [
                    'type' => Types::listOf(Types::story()),
                    'description' => 'Returns subset of stories posted for this blog',
                    'args' => [
                        'after' => [
                            'type' => Types::id(),
                            'description' => 'Fetch stories listed after the story with this ID'
                        ],
                        'limit' => [
                            'type' => Types::int(),
                            'description' => 'Number of stories to be returned',
                            'defaultValue' => 10
                        ]
                    ]
                ],
                'lastStoryPosted' => [
                    'type' => Types::story(),
                    'description' => 'Returns last story posted for this blog'
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

    public function savings($rootValue, $args)
	{
		return $this->context->services->savings->selectSavings($rootValue, $args);
	}

    public function snapshots($rootValue, $args)
	{
		return $this->context->services->snapshot->selectSnapshots($rootValue, $args);
	}





// todo: Dead below here
    public function user($rootValue, $args)
    {
        return DataSource::findUser($args['id']);
    }

    public function viewer($rootValue, $args, AppContext $context)
    {
        return $context->viewer;
    }

    public function stories($rootValue, $args)
    {
        $args += ['after' => null];
        return DataSource::findStories($args['limit'], $args['after']);
    }

    public function lastStoryPosted()
    {
        return DataSource::findLatestStory();
    }
}
