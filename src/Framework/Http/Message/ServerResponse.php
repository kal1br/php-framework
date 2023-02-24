<?php

declare(strict_types=1);

namespace Framework\Http\Message;

class ServerResponse
{
    protected array $headers;
    protected string $content;
    protected int $statusCode;

    public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendContent();
        die;
    }

    public function sendHeaders(): static
    {
        foreach ($this->headers as $name => $values) {
            foreach ($values as $value) {
                header($name . ': ' . $value);
            }
        }

        http_response_code($this->statusCode);

        return $this;
    }

    public function sendContent(): static
    {
        echo $this->content;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        $result = [];

        foreach ($this->headers as $name => $value) {
            $result[$name] = count($value) > 1 ? $value : $value[0];
        }

        return $result;
    }

    /**
     * @param string $name
     * @return array|string
     */
    public function getHeader(string $name): array|string
    {
        if (is_array($this->headers[$name])) {
            if (count($this->headers[$name]) > 1) {
                return $this->headers[$name];
            } else {
                return $this->headers[$name][0];
            }
        }

        return '';
    }

    public function setHeader($name, $value): static
    {
        $this->headers[$name][] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }
}
