<?php

declare(strict_types=1);

namespace Test\Framework\Http\Message;

use Framework\Http\Message\ServerResponse;
use PHPUnit\Framework\TestCase;

class ServerResponseTest extends TestCase
{
    public function testCreate(): void
    {
        $headers = ['X-header' => 'value'];
        $statusCode = 202;
        $content = 'hello';

        $response = new ServerResponse();
        $response->setHeaders($headers);
        $response->setStatusCode($statusCode);
        $response->setContent($content);

        ob_start();
        $response->sendContent();
        $resultContent = ob_get_contents();
        ob_end_clean();

        self::assertEquals($headers, $response->getHeaders());
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals($content, $response->getContent());
        self::assertEquals($content, $resultContent);
    }
}
