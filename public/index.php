<?php

require_once('bootstrap.php');

use Api\Acl;
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
$config->setDb(Config::get('mongo.db'));
$config->setRecordFactory(new RecordFactory());

ConfigurationManager::getInstance()->setDefaultConfiguration($config);

$request = Request::getInstance();

$methodFactory = new MethodFactory();
$formatFactory = new FormatFactory();

$format = $formatFactory->create($request->fetch('format'), $request);
$method = $methodFactory->create($request->fetch('method'));

$response = new Response();
$response->setFormat($format);

if ($method !== null) {
    $method->setAcl(new Acl());
    $method->setResponse($response);

    try {
        $method->call($request->get());
    } catch (Exception $error) {
        $response->addError($error->getMessage(), 500);
    }


} else {
    $response->addError('Unknown method calling', 404);
}

$response->render();

?>