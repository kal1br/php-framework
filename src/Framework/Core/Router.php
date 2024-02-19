<?php

declare(strict_types=1);

namespace Framework\Core;

use Framework\Http\Message\ServerRequest;

class Router
{
    public const PATH_FILE = '/data/routes.php';

    private static ?Router $instance = null;

    protected array $routes = [];

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function get(string $path, string $handler, string $action): void
    {
        self::getInstance()->addRoute('GET', $path, $handler, $action);
    }

    public static function post(string $path, string $handler, string $action): void
    {
        self::getInstance()->addRoute('POST', $path, $handler, $action);
    }

    public function addRoute(string $method, string $path, string $handler, $action): void
    {
        $this->routes[$method][$path] = [
            'handler' => $handler,
            'action' => $action,
        ];
    }

    public function match(ServerRequest $request): ?array
    {
        $uri = $request->getUri()->getPath();
        $method = $request->getMethod();

        foreach ($this->routes[$method] as $path => $route) {
            $pattern = '~^' . preg_replace('/{([a-zA-Z]+)}/', '(?P<$1>[^/]+)', $path) . '$~';

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY);
                return [
                    'controller' => $route['handler'],
                    'action' => $route['action'],
                    'params' => $params,
                ];
            }
        }

        return null;
    }
}
