<?php

declare(strict_types=1);

namespace Framework\Core\Application;

use Framework\Core\Container\DIContainer;
use Framework\Core\Handlers\ExceptionHandler;
use Framework\Core\Router;
use Framework\Core\Util\Config;
use Framework\Http\Message\ServerRequest;
use Framework\Http\Message\ServerResponse;

class App extends DIContainer
{
    public function __construct()
    {
        $this->registerCoreContainers();
    }

    public function registerCoreContainers(): void
    {
        foreach ([
            'app' => App::class,
            'kernel' => Kernel::class,
            'config' => Config::getInstance(),
            'router' => Router::getInstance(),
            'request' => ServerRequest::createFromGlobals(),
            'response' => ServerResponse::class,
            'handler' => ExceptionHandler::class,
        ] as $key => $container) {
            $this->register($key, $container);
        }
    }
}
