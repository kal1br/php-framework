<?php

declare(strict_types=1);

namespace Framework\Core\Application;

use Framework\Core\Handlers\ExceptionHandler;
use Framework\Core\Router;
use Framework\Http\Message\ServerRequest;

class App
{
    public function run(): void
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/../.' . Router::PATH_FILE;

        $kernel = new Kernel(
            Router::getInstance(),
            new ExceptionHandler()
        );

        $response = $kernel->handle(ServerRequest::createFromGlobals());
        $response->send();
    }
}
