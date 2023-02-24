<?php

declare(strict_types=1);

namespace Framework;

use Framework\Http\Message\ServerRequest;

class Router
{
    protected ServerRequest $request;

    protected array $routes = [];

    public function __construct()
    {
        $this->request = ServerRequest::createFromGlobals();
    }

    public function addRoute($url, $controller, $action): void
    {
        $pattern = preg_replace('/\//', '\\/', $url);
        $pattern = '/^' . $pattern . '$/';

        $this->routes[$pattern] = [
            'controller' => $controller,
            'action' => $action,
        ];
    }

    public function getCurrentRoute()
    {
        $url = $this->request->getUri()->getPath();
        $method = $this->request->getMethod();

        foreach ($this->routes as $pattern => $route) {
            if (preg_match($pattern, $url, $matches) && strtoupper($method) == 'GET') {
                $route['params'] = array_slice($matches, 1);
                return $route;
            } elseif (preg_match($pattern, $url, $matches) && strtoupper($method) == 'POST') {
                $route['params'] = $this->request->getParsedBody();
                return $route;
            }
        }

        return null;
    }
}
