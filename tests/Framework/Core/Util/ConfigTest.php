<?php

declare(strict_types=1);

namespace Test\Framework\Core\Util;

use Framework\Core\Util\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testCreate(): void
    {
        $config = new Config(['test' => true]);
        $config->set('secondTest', 3);

        self::assertEquals(true, $config->has('test'));
        self::assertEquals(true, $config->has('secondTest'));
        self::assertEquals(false, $config->has('thirdTest'));

        self::assertEquals(true, $config->get('test'));
        self::assertEquals(3, $config->get('secondTest'));
    }
}
