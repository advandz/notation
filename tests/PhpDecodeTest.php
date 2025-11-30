<?php

declare(strict_types=1);

namespace Advandz\Toon\Tests;

use Advandz\Notation\Php;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Php::decode() method
 */
class PhpDecodeTest extends TestCase
{
    public function testDecodeSimpleSerialized(): void
    {
        $serialized = 'a:2:{s:4:"name";s:4:"John";s:3:"age";i:30;}';
        $result = Php::decode($serialized);

        Assert::type('object', $result);
        Assert::same('John', $result->name);
        Assert::same(30, $result->age);
    }

    public function testDecodeAsArray(): void
    {
        $serialized = 'a:2:{s:4:"name";s:4:"Jane";s:3:"age";i:25;}';
        $result = Php::decode($serialized, true);

        Assert::type('array', $result);
        Assert::same('Jane', $result['name']);
        Assert::same(25, $result['age']);
    }

    public function testDecodeBoolean(): void
    {
        $serialized = 'a:2:{s:7:"enabled";b:1;s:8:"disabled";b:0;}';
        $result = Php::decode($serialized, true);

        Assert::type('array', $result);
        Assert::true($result['enabled']);
        Assert::false($result['disabled']);
    }

    public function testDecodeInteger(): void
    {
        $serialized = 'a:1:{s:5:"count";i:42;}';
        $result = Php::decode($serialized, true);

        Assert::type('array', $result);
        Assert::same(42, $result['count']);
    }

    public function testRoundTrip(): void
    {
        $data = [
            'database' => [
                'host' => 'localhost',
                'port' => 5432
            ]
        ];
        $result = Php::decode(Php::encode($data), true);

        Assert::type('array', $result);
        Assert::same(5432, $result['database']['port']);
    }

    public function testValidate(): void
    {
        $validSerialized = 'a:2:{s:4:"name";s:4:"John";s:3:"age";i:30;}';
        Assert::true(Php::validate($validSerialized));

        $invalidSerialized = 'not valid serialized data';
        Assert::false(Php::validate($invalidSerialized));
    }
}

(new PhpDecodeTest())->run();
