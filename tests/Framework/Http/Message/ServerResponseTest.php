<?php

declare(strict_types=1);

namespace Test\Framework\Http\Message;

use Framework\Http\Message\ServerResponse;
use PHPUnit\Framework\TestCase;

class ServerResponseTest extends TestCase
{
    public function testCreate(): void
    {
        $statusCode = 202;
        $content = 'hello';

        $response = new ServerResponse();
        $response->setHeader('X-header', 'value');
        $response->setStatusCode($statusCode);
        $response->setContent($content);

        ob_start();
        $response->sendContent();
        $resultContent = ob_get_contents();
        ob_end_clean();

        self::assertEquals(['X-header' => 'value'], $response->getHeaders());
        self::assertEquals('value', $response->getHeader('X-header'));
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals($content, $response->getContent());
        self::assertEquals($content, $resultContent);
    }
}
