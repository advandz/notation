<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Neon;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Neon::decode() method
 */
class NeonDecodeTest extends TestCase
{
    public function testDecodeSimpleNeon(): void
    {
        $neon = "name: John\nage: 30";
        $result = Neon::decode($neon);

        Assert::type('object', $result);
        Assert::same('John', $result->name);
        Assert::same(30, $result->age);
    }

    public function testDecodeAsArray(): void
    {
        $neon = "name: Jane\nage: 25";
        $result = Neon::decode($neon, true);

        Assert::type('array', $result);
        Assert::same('Jane', $result['name']);
        Assert::same(25, $result['age']);
    }

    public function testDecodeBoolean(): void
    {
        $yaml = "enabled: true\ndisabled: false";
        $result = Neon::decode($yaml, true);

        Assert::true($result['enabled']);
        Assert::false($result['disabled']);
    }

    public function testDecodeArray(): void
    {
        $neon = "- 1\n- 2\n- 3";
        $result = Neon::decode($neon, true);

        Assert::type('array', $result);
        Assert::same([1, 2, 3], $result);
    }

    public function testRoundTrip(): void
    {
        $data = [
            'database' => [
                'host' => 'localhost',
                'port' => 5432
            ]
        ];
        $result = Neon::decode(Neon::encode($data), true);

        Assert::type('array', $result);
        Assert::same(5432, $result['database']['port']);
    }

    public function testValidate(): void
    {
        $validNeon = "name: Jane\nage: 25";
        Assert::true(Neon::validate($validNeon));

        $invalidNeon = 'invalid: {] syntax';
        Assert::false(Neon::validate($invalidNeon));
    }
}

(new NeonDecodeTest())->run();
