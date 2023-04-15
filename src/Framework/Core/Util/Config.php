<?php

declare(strict_types=1);

namespace Framework\Core\Util;

class Config
{
    private static ?Config $instance = null;

    private array $config;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function set(string $key, $value): void
    {
        $this->config[$key] = $value;
    }

    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }
}
