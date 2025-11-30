<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Neon;
use Advandz\Notation\Common\Notation;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Neon::encode() method
 */
class NeonEncodeTest extends TestCase
{
    public function testEncodeSimpleArray(): void
    {
        $data = ['name' => 'John', 'age' => 30];
        $result = Neon::encode($data);

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
        $result = Neon::encode($data);

        Assert::type('string', $result);
        Assert::contains('Alice', $result);
    }

    public function testEncodeNull(): void
    {
        $result = Neon::encode(null);
        Assert::contains('null', $result);
    }

    public function testEncodeBoolean(): void
    {
        Assert::contains('true', Neon::encode(true));
        Assert::contains('false', Neon::encode(false));
    }

    public function testEncodeArray(): void
    {
        $data = [1, 2, 3, 4, 5];
        $result = Neon::encode($data);

        Assert::type('string', $result);
    }
}

(new NeonEncodeTest())->run();
