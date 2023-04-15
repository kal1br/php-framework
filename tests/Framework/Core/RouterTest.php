<?php

declare(strict_types=1);

namespace Test\Framework\Core;

use Framework\Core\Router;
use Framework\Http\Message\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testMatch(): void
    {
        Router::get('/path', 'handler', 'action');

        $router = Router::getInstance();
        $request = new ServerRequest(
            [
                'HTTP_HOST' => 'localhost',
                'REQUEST_URI' => '/path',
                'REQUEST_METHOD' => 'GET',
            ],
            [],
            [],
            []
        );
        $math = $router->match($request);

        self::assertEquals('handler', $math['controller']);
        self::assertEquals('action', $math['action']);
    }
}
