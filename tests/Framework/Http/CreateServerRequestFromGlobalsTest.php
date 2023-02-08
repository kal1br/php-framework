<?php

declare(strict_types=1);

namespace Test\Framework\Http;

use PHPUnit\Framework\TestCase;

use function Framework\Http\createServerRequestFromGlobals;

/**
 * @internal
 */
final class CreateServerRequestFromGlobalsTest extends TestCase
{
    public function testGlobals(): void
    {
        $server = [
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/home?a=2',
            'REQUEST_METHOD' => 'POST',
            'CONTENT_TYPE' => 'text/plain',
            'CONTENT_LENGTH' => '4',
            'HTTP_ACCEPT_LANGUAGE' => 'en',
        ];
        $query = ['param' => 'value'];
        $cookies = ['name' => 'John'];
        $body = ['age' => '42'];
        $input = fopen('php://memory', 'r+');
        fwrite($input, 'Body');

        $request = createServerRequestFromGlobals($server, $query, $cookies, $body, $input);

        self::assertEquals($server, $request->getServerParams());
        self::assertEquals('http://localhost/home?a=2', (string)$request->getUri());
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals($query, $request->getQueryParams());
        self::assertEquals([
            'Host' => 'localhost',
            'Content-Type' => 'text/plain',
            'Content-Length' => '4',
            'Accept-Language' => 'en',
        ], $request->getHeaders());
        self::assertEquals($cookies, $request->getCookies());
        self::assertEquals('Body', (string)$request->getBody());
        self::assertEquals($body, $request->getParsedBody());

        self::assertEquals($server['HTTP_HOST'], $request->getServerParam('HTTP_HOST'));
        self::assertEquals($query['param'], $request->getQueryParam('param'));
        self::assertEquals('localhost', $request->getHeader('Host'));
        self::assertEquals('John', $request->getCookie('name'));
    }
}
