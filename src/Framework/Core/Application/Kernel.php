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
    private DIContainer $container;
    private Router $router;
    private ServerRequest $request;
    private ServerResponse $response;

    public function __construct(DIContainer $container)
    {
        $this->container = $container;
        $this->router = $container->get('router');
    }

    /**
     * @param ServerRequest $request
     * @return ServerResponse
     * @throws Exception
     */
    public function handle(ServerRequest $request): ServerResponse
    {
        $this->request = $request;

        $this->response = $this->container->get('response');

        $this->routeRequest();

        return $this->response;
    }

    /**
     * @throws Exception
     */
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

            if (!$this->response instanceof ServerResponse) {
                throw new \Exception("Controller methods must return a Response object.");
            }

            $this->response = call_user_func_array([$controller, $actionName], $params);

        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * @throws Exception
     */
    private function handleException(Exception $e): void
    {
        $handler = $this->container->get(ExceptionHandler::class);

        $response = $handler->handle($e);

        if (!$response instanceof ServerResponse) {
            throw new Exception("Exception handlers must return a Response object.");
        }

        $this->response = $response;
    }
}
