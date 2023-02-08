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
        Uri $uri,
        string $method,
        array $queryParams,
        array $headers,
        array $cookies,
        Stream $body,
        ?array $parsedBody
    ) {
        $this->serverParams = $serverParams;
        $this->uri = $uri;
        $this->method = $method;
        $this->queryParams = $queryParams;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->body = $body;
        $this->parsedBody = $parsedBody;
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
