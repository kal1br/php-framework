<?php

declare(strict_types=1);


require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../routes.php';

$app = new \Framework\Application();

$app->run();
