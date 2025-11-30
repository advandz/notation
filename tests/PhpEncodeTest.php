<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Php;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Php::encode() method
 */
class PhpEncodeTest extends TestCase
{
    public function testEncodeSimpleArray(): void
    {
        $data = ['name' => 'John', 'age' => 30];
        $result = Php::encode($data);

        Assert::type('string', $result);
        Assert::contains('name', $result);
        Assert::contains('John', $result);
    }

    public function testEncodeObject(): void
    {
        $data = (object) ['name' => 'Jane', 'age' => 25];
        $result = Php::encode($data);

        Assert::type('string', $result);
        Assert::contains('stdClass', $result);
    }

    public function testEncodeNull(): void
    {
        $result = Php::encode(null);
        Assert::contains('N;', $result);
    }

    public function testEncodeBoolean(): void
    {
        Assert::contains('b:1;', Php::encode(true));
        Assert::contains('b:0;', Php::encode(false));
    }

    public function testEncodeInteger(): void
    {
        $result = Php::encode(42);
        Assert::contains('i:42;', $result);
    }
}

(new PhpEncodeTest())->run();
