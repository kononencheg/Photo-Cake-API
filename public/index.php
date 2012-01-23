<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/bootstrap.php');

use Api\Methods\MethodFactory;

use Model\RecordFactory;

use PhotoCake\App\Config;

use PhotoCake\Db\Configuration\ConfigurationManager;
use PhotoCake\Db\Mongo\MongoConfiguration;

use PhotoCake\Http\Request;
use PhotoCake\Http\Response\Response;
use PhotoCake\Http\Response\Format\FormatFactory;

Config::load(INI_FILE);

$config = new MongoConfiguration();
$config->setDb('cakes');
$config->setRecordFactory(new RecordFactory());

ConfigurationManager::getInstance()->setDefaultConfiguration($config);

$request = Request::getInstance();

$methodFactory = new MethodFactory();
$formatFactory = new FormatFactory();

$format = $formatFactory->create($request->fetch('format'), $request);
$method = $methodFactory->create($request->fetch('method'));

$response = new Response();
$response->setFormat($format);

if ($method !== NULL) {
    $method->setResponse($response);
    $method->call($request->get());
} else {
    $response->addError('Unknown method calling', 404);
}

$response->render();

?>