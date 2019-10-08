<?php
require_once __DIR__ . '/vendor/autoload.php';

use GraphQL\Error\Debug;
use GraphQL\Error\FormattedError;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use ILoveAustin\AppContext;
use ILoveAustin\Context\Context;
use ILoveAustin\Types;

// Disable default PHP error reporting - we have better one for debug mode (see below)
ini_set('display_errors', 1);


$debug = false;
if (!empty($_GET['debug'])) {
	set_error_handler(function($severity, $message, $file, $line) use (&$phpErrors) {
		throw new ErrorException($message, 0, $severity, $file, $line);
	});
	$debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;
}

try {
	// use real datasource
	DB::$user = 'root';
	DB::$password = 'root';
	DB::$dbName = 'iloveaustin';

	// Prepare context that will be available in all field resolvers (as 3rd argument):
	$appContext = new AppContext();
	$appContext->viewer = null;
	$appContext->rootUrl = 'http://localhost:8080';
	$appContext->request = $_REQUEST;

	// Parse incoming query and variables
	if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
		$raw = file_get_contents('php://input') ?: '';
		$data = json_decode($raw, true) ?: [];
	} else {
		$data = $_REQUEST;
	}

	$data += ['query' => null, 'variables' => null];

	// GraphQL schema to be passed to query executor:
	$context = new Context();
	$schema = new Schema([
		'query' => Types::query($context),
		'mutation' => Types::mutation($context),
	]);

	$result = GraphQL::executeQuery(
		$schema,
		$data['query'],
		null,
		$appContext,
		(array) $data['variables']
	);
	$output = $result->toArray($debug);
	$httpStatus = 200;
} catch (\Exception $error) {
	$httpStatus = 500;
	$output['errors'] = [
		FormattedError::createFromException($error, $debug)
	];
}

header('Content-Type: application/json', true, $httpStatus);
echo json_encode($output);