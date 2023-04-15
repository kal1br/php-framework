<?php

declare(strict_types=1);


use Framework\Core\Application\App;
use Framework\Core\Application\Kernel;
use Framework\Http\Message\ServerRequest;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../routes.php';

$app = new App();
$kernel = new Kernel($app);
$response = $kernel->handle(ServerRequest::createFromGlobals());
$response->send();
