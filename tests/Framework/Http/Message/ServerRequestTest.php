<?php

declare(strict_types=1);

namespace Test\Framework\Http\Message;

use Framework\Http\Message\ServerRequest;
use Framework\Http\Message\Stream;
use Framework\Http\Message\Uri;
use PHPUnit\Framework\TestCase;

final class ServerRequestTest extends TestCase
{
    public function testCreate(): void
    {
        $serverParams = [
            'REQUEST_SCHEME' => 'https',
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/home',
            'REQUEST_METHOD' => 'POST',
        ];

        $input = fopen('php://memory', 'r+');
        fwrite($input, 'Body');

        $request = new ServerRequest(
            serverParams: $serverParams,
            queryParams: $queryParams = ['name' => 'john'],
            cookies: $cookies = ['Cookie' => 'Value'],
            parsedBody: $parsedBody = ['title' => 'title'],
            body: $input
        );

        self::assertEquals($serverParams, $request->getServerParams());
        self::assertEquals('https://localhost/home', $request->getUri());
        self::assertEquals($serverParams['REQUEST_METHOD'], $request->getMethod());
        self::assertEquals($queryParams, $request->getQueryParams());
        self::assertEquals(['Content-Type' => '', 'Content-Length' => '', 'Host' => 'localhost'], $request->getHeaders());
        self::assertEquals($cookies, $request->getCookies());
        self::assertEquals($parsedBody, $request->getParsedBody());
        self::assertEquals('Body', (string)$request->getBody());
        self::assertEquals($serverParams['HTTP_HOST'], $request->getServerParam('HTTP_HOST'));
        self::assertEquals($queryParams['name'], $request->getQueryParam('name'));
        self::assertEquals($serverParams['HTTP_HOST'], $request->getHeader('Host'));
        self::assertEquals($cookies['Cookie'], $request->getCookie('Cookie'));
    }
}
