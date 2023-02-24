<?php

declare(strict_types=1);


require_once __DIR__ . '/../vendor/autoload.php';

$router = require_once __DIR__ . '/../src/App/config/routes.php';

$app = new \Framework\Application($router);

$app->run();
