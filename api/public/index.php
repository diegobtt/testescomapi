<?php

use app\controllers\HomeController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

require '../app/routes/api.php';


$app->add(function ($request, $handler) {

    $response = new \Slim\Psr7\Response();
    $response = $response->withHeader('Access-Control-Allow-Origin', '*')
                         ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                         ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');


    if ($request->getMethod() === 'OPTIONS') {
        return $response;
    }


    $response = $handler->handle($request);

    return $response->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                    ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});


$app->run();