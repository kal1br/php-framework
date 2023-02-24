<?php

declare(strict_types=1);

namespace Framework;

use Framework\Http\Message\ServerResponse;

class Application
{
    protected Router $router;
    protected ServerResponse $response;

    public function __construct()
    {
        $this->router = Router::getInstance();
        $this->response = new ServerResponse();
    }

    public function run(): void
    {
        $route = $this->router->getCurrentRoute();

        if (!$route) {
            $this->sendResponse(404, 'Page not found');
        }

        $controllerName = $route['controller'];
        $actionName = $route['action'];

        $controllerClass = '\\App\\controllers\\' . ucfirst($controllerName) . 'Controller';

        if (!class_exists($controllerClass)) {
            $this->sendResponse(404, 'Page not found');
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $actionName)) {
            $this->sendResponse(404, 'Page not found');
        }

        $params = $route['params'];

        try {
            call_user_func_array([$controller, $actionName], $params);
        } catch (\Throwable $e) {
            $this->sendResponse(500, 'Internal server error');
        }
    }

    protected function sendResponse(int $code, string $content): void
    {
        $this->response->setStatusCode($code);
        $this->response->setContent($content);
        $this->response->send();
    }
}
