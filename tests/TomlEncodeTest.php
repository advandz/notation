<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Toml;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Toml::encode() method
 */
class TomlEncodeTest extends TestCase
{
    public function testEncodeSimpleArray(): void
    {
        $data = ['name' => 'John', 'age' => 30];
        $result = Toml::encode($data);

        Assert::type('string', $result);
        Assert::contains('name', $result);
        Assert::contains('John', $result);
    }

    public function testEncodeNestedStructure(): void
    {
        $data = [
            'database' => [
                'host' => 'localhost',
                'port' => 5432
            ]
        ];
        $result = Toml::encode($data);

        Assert::type('string', $result);
        Assert::contains('database', $result);
        Assert::contains('localhost', $result);
    }

    public function testEncodeBoolean(): void
    {
        $result = Toml::encode(['enabled' => true]);
        Assert::contains('true', $result);
    }

    public function testEncodeInteger(): void
    {
        $result = Toml::encode(['count' => 42]);
        Assert::contains('42', $result);
    }

    public function testEncodeString(): void
    {
        $result = Toml::encode(['title' => 'TOML Example']);
        Assert::contains('TOML Example', $result);
    }
}

(new TomlEncodeTest())->run();
