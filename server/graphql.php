<?php
$origin = $_SERVER['HTTP_ORIGIN'];
$allowed_domains = [
	'http://localhost:9000',
	'https://rpggenerator.com',
];

if (in_array($origin, $allowed_domains)) {
	header('Access-Control-Allow-Origin: ' . $origin);
	header('Access-Control-Allow-Headers: *');
}
if($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
	exit(0);
}

// Disable default PHP error reporting - we have better one for debug mode (see below)
ini_set('display_errors', 1);
// ini_set('display_errors', 0);
// $appDir = '/home/rpggener/apps/iloveaustin';
$appDir = __DIR__;
require_once $appDir . '/vendor/autoload.php';

use GraphQL\Error\Debug;
use GraphQL\Error\FormattedError;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use ILoveAustin\AppContext;
use ILoveAustin\Context\Context;
use ILoveAustin\Types;


$debug = false;
if (!empty($_GET['debug'])) {
	set_error_handler(function($severity, $message, $file, $line) use (&$phpErrors) {
		throw new ErrorException($message, 0, $severity, $file, $line);
	});
	$debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;
}

try {
	// use real datasource
	require_once $appDir . '/src/Resources/database.php';

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