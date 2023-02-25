<?php

declare(strict_types=1);

namespace Framework\Core;

use Framework\Core\Exception\ExceptionHandler;
use Framework\Http\Message\ServerResponse;

class Application
{
    protected Router $router;
    protected ServerResponse $response;
    protected Config $config;
    protected ExceptionHandler $exceptionHandler;

    public function __construct(
        Config $config,
        Router $router,
        ServerResponse $response,
        ExceptionHandler $exceptionHandler
    ) {
        $this->config = $config;
        $this->router = $router;
        $this->response = $response;
        $this->exceptionHandler = $exceptionHandler;
    }

    public function run(): ServerResponse
    {
        $route = $this->router->getCurrentRoute();

        if (!$route) {
            $this->response->setStatusCode(404);
            $this->response->setContent('Page not found');
            return $this->response;
        }

        $controllerName = $route['controller'];
        $actionName = $route['action'];

        $controllerClass = '\\App\\controllers\\' . ucfirst($controllerName) . 'Controller';

        if (!class_exists($controllerClass)) {
            $this->response->setStatusCode(404);
            $this->response->setContent('Page not found');
            return $this->response;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $actionName)) {
            $this->response->setStatusCode(404);
            $this->response->setContent('Page not found');
            return $this->response;
        }

        $params = $route['params'];

        try {
            return call_user_func_array([$controller, $actionName], $params);
        } catch (\Throwable $e) {
            return $this->exceptionHandler->handle($e);
        }
    }
}
