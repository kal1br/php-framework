<?php

declare(strict_types=1);

namespace Framework\Core\Container;

use PHPUnit\Framework\TestCase;

class DIContainerTest extends TestCase
{
    public function testCreate(): void
    {
        $container = new DIContainer();
        $container->register('test', DIContainer::class);

        $result = ($container->get('test') instanceof DIContainer);

        self::assertEquals(true, $result);
    }
}
