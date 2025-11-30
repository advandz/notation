<?php

declare(strict_types=1);

namespace Advandz\Toon\Tests;

use Advandz\Notation\Yaml;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Yaml::encode() method
 */
class YamlEncodeTest extends TestCase
{
    public function testEncodeSimpleArray(): void
    {
        $data = ['name' => 'John', 'age' => 30];
        $result = Yaml::encode($data);

        Assert::type('string', $result);
        Assert::contains('John', $result);
        Assert::contains('30', $result);
    }

    public function testEncodeNestedStructure(): void
    {
        $data = [
            'user' => [
                'name' => 'Alice',
                'email' => 'alice@example.com'
            ]
        ];
        $result = Yaml::encode($data);

        Assert::type('string', $result);
        Assert::contains('Alice', $result);
    }

    public function testEncodeNull(): void
    {
        $result = Yaml::encode(null);
        Assert::contains('null', $result);
    }

    public function testEncodeBoolean(): void
    {
        $result = Yaml::encode(['enabled' => true, 'disabled' => false]);
        Assert::contains('true', $result);
        Assert::contains('false', $result);
    }

    public function testEncodeArray(): void
    {
        $data = [1, 2, 3, 4, 5];
        $result = Yaml::encode($data);

        Assert::type('string', $result);
    }
}

(new YamlEncodeTest())->run();
