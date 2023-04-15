<?php

declare(strict_types=1);

namespace Framework\Core\Container;

use Exception;

class DIContainer
{
    private array $services = [];

    public function register($name, $service): void
    {
        $this->services[$name] = $service;
    }

    public function get($name)
    {
        if (!isset($this->services[$name])) {
            throw new Exception("Service not found: {$name}");
        }

        if (is_object($this->services[$name])) {
            return $this->services[$name];
        }

        return new $this->services[$name]();
    }
}
