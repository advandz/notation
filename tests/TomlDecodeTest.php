<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Toml;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Toml::decode() method
 */
class TomlDecodeTest extends TestCase
{
    public function testDecodeSimpleToml(): void
    {
        $toml = 'name = "John"';
        $result = Toml::decode($toml, true);

        Assert::type('array', $result);
        Assert::same('John', $result['name']);
    }

    public function testDecodeAsArray(): void
    {
        $toml = "name = \"Jane\"\nage = 25";
        $result = Toml::decode($toml, true);

        Assert::type('array', $result);
        Assert::same('Jane', $result['name']);
        Assert::same(25, $result['age']);
    }

    public function testDecodeTable(): void
    {
        $toml = "[database]\nhost = \"localhost\"\nport = 5432";
        $result = Toml::decode($toml, true);

        Assert::type('array', $result);
        Assert::same('localhost', $result['database']['host']);
        Assert::same(5432, $result['database']['port']);
    }

    public function testDecodeBoolean(): void
    {
        $toml = "enabled = true\ndisabled = false";
        $result = Toml::decode($toml, true);

        Assert::true($result['enabled']);
        Assert::false($result['disabled']);
    }

    public function testDecodeInteger(): void
    {
        $toml = "count = 42";
        $result = Toml::decode($toml, true);

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
        $result = Toml::decode(Toml::encode($data), true);

        Assert::type('array', $result);
        Assert::same(5432, $result['database']['port']);
    }

    public function testValidate(): void
    {
        $validToml = 'name = "John"';
        Assert::true(Toml::validate($validToml));

        $invalidToml = 'invalid = {] syntax';
        Assert::false(Toml::validate($invalidToml));
    }
}

(new TomlDecodeTest())->run();
