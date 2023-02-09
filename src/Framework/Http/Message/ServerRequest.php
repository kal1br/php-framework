<?php

declare(strict_types=1);

namespace Framework\Http\Message;

final class ServerRequest
{
    protected array $serverParams;
    protected Uri $uri;
    protected string $method;
    protected array $queryParams;
    protected array $headers;
    protected array $cookies;
    protected Stream $body;
    protected ?array $parsedBody;

    public function __construct(
        array $serverParams,
        array $queryParams,
        array $cookies,
        ?array $parsedBody,
        mixed $body = null
    ) {
        $this->serverParams = $serverParams;
        $this->queryParams = $queryParams;
        $this->cookies = $cookies;
        $this->parsedBody = $parsedBody;

        $this->uri = $this->initUri();
        $this->headers = $this->initHeaders();
        $this->method = $this->initMethod();
        $this->body = $body ? new Stream($body) : $this->initBody();
    }

    public static function createFromGlobals(): ServerRequest
    {
        return new self(
            serverParams: $_SERVER,
            queryParams: $_GET,
            cookies: $_COOKIE,
            parsedBody: $_POST,
        );
    }

    protected function initUri(): Uri
    {
        $scheme = $this->serverParams['REQUEST_SCHEME'] ?? 'http';
        $host = $this->serverParams['HTTP_HOST'] ?? '';
        $uri = $this->serverParams['REQUEST_URI'] ?? '';

        return new Uri($scheme . '://' . $host . $uri);
    }

    protected function initHeaders(): array
    {
        $headers = [
            'Content-Type' => $this->serverParams['CONTENT_TYPE'] ?? '',
            'Content-Length' => $this->serverParams['CONTENT_LENGTH'] ?? '',
        ];

        foreach ($this->serverParams as $serverName => $serverValue) {
            if (str_starts_with($serverName, 'HTTP_')) {
                $name = ucwords(strtolower(str_replace('_', '-', substr($serverName, 5))), '-');
                $headers[$name] = $serverValue;
            }
        }

        return $headers;
    }

    protected function initMethod(): string
    {
        return $this->serverParams['REQUEST_METHOD'] ?? '';
    }

    protected function initBody(): Stream
    {
        return new Stream(fopen('php://input', 'r'));
    }

    public function getServerParams(): array
    {
        return $this->serverParams;
    }

    public function getServerParam(string $name): string
    {
        return $this->serverParams[$name];
    }

    public function getUri(): Uri
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getQueryParam(string $name): string
    {
        return $this->queryParams[$name];
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name): string
    {
        return $this->headers[$name];
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getCookie(string $name): string
    {
        return $this->cookies[$name];
    }

    public function getBody(): Stream
    {
        return $this->body;
    }

    public function getParsedBody(): ?array
    {
        return $this->parsedBody;
    }
}
