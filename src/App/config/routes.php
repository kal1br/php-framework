<?php

declare(strict_types=1);

use Framework\Router;

$router = new Router();

$router->addRoute('/', 'home', 'index');

return $router;
