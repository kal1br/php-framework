<?php

declare(strict_types=1);


use Framework\Core\Application;
use Framework\Core\Config;
use Framework\Core\Exception\ExceptionHandler;
use Framework\Core\Router;
use Framework\Http\Message\ServerResponse;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../routes.php';

$config = new Config([
    'production' => false,
]);

$router = Router::getInstance();

$serverResponse = new ServerResponse();

$exceptionHandler = new ExceptionHandler($config->get('production'));

$app = new Application($config, $router, $serverResponse, $exceptionHandler);

$response = $app->run();
$response->send();
