<?php

declare(strict_types=1);

namespace Framework\Core\Application;

use Exception;
use Framework\Core\Container\DIContainer;
use Framework\Core\Handlers\ExceptionHandler;
use Framework\Core\Router;
use Framework\Http\Message\ServerRequest;
use Framework\Http\Message\ServerResponse;

class Kernel
{
    private Router $router;
    private ExceptionHandler $handler;
    private ServerRequest $request;
    private ServerResponse $response;

    public function __construct(Router $router, ExceptionHandler $handler)
    {
        $this->router = $router;
        $this->handler = $handler;
    }

    /**
     * @param ServerRequest $request
     * @return ServerResponse
     */
    public function handle(ServerRequest $request): ServerResponse
    {
        $this->request = $request;

        $this->response = new ServerResponse();

        $this->routeRequest();

        return $this->response;
    }

    private function routeRequest(): void
    {
        try {
            $route = $this->router->match($this->request);

            if (!$route) {
                $this->response->setStatusCode(404);
                $this->response->setContent('Page not found');
                return;
            }

            $controllerName = $route['controller'];
            $actionName = $route['action'];

            $controllerClass = '\\App\\controllers\\' . ucfirst($controllerName) . 'Controller';

            if (!class_exists($controllerClass)) {
                $this->response->setStatusCode(404);
                $this->response->setContent('Page not found');
                return;
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $actionName)) {
                $this->response->setStatusCode(404);
                $this->response->setContent('Page not found');
                return;
            }

            $params = $route['params'];

            $this->response = call_user_func_array([$controller, $actionName], $params);

        } catch (Exception $e) {
            $this->response = $this->handler->handle($e);
        }
    }
}
