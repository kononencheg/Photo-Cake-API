<?php

require_once('bootstrap.php');

use Api\Acl;
use Api\Methods\Social\Ok\PaymentCallback;

use Model\RecordFactory;

use PhotoCake\App\Config;

use PhotoCake\Db\Configuration\ConfigurationManager;
use PhotoCake\Db\Mongo\MongoConfiguration;

use PhotoCake\Http\Request;
use PhotoCake\Http\Response\Response;
use PhotoCake\Http\Response\Format\RawFormat;

Config::load(INI_FILE);

$config = new MongoConfiguration();
$config->setDb(Config::get('mongo.db'));
$config->setRecordFactory(new RecordFactory());

ConfigurationManager::getInstance()->setDefaultConfiguration($config);

$request = Request::getInstance();

$method = new PaymentCallback();
$format = new RawFormat();
$format->setMimeType('application/xml');


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
