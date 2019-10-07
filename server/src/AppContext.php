<?php
namespace ILoveAustin;

use ILoveAustin\Data\User;

/**
 * Class AppContext
 * Instance available in all GraphQL resolvers as 3rd argument
 *
 * @package ILoveAustin
 */
class AppContext
{
    /**
     * @var string
     */
    public $rootUrl;

    /**
     * @var User
     */
    public $viewer;

    /**
     * @var \mixed
     */
    public $request;
}
