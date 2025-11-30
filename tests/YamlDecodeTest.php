<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Yaml;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Yaml::decode() method
 */
class YamlDecodeTest extends TestCase
{
    public function testDecodeSimpleYaml(): void
    {
        $yaml = "name: John\nage: 30";
        $result = Yaml::decode($yaml);

        Assert::type('object', $result);
        Assert::same('John', $result->name);
        Assert::same(30, $result->age);
    }

    public function testDecodeAsArray(): void
    {
        $yaml = "name: Jane\nage: 25";
        $result = Yaml::decode($yaml, true);

        Assert::type('array', $result);
        Assert::same('Jane', $result['name']);
        Assert::same(25, $result['age']);
    }

    public function testDecodeBoolean(): void
    {
        $yaml = "enabled: true\ndisabled: false";
        $result = Yaml::decode($yaml, true);

        Assert::true($result['enabled']);
        Assert::false($result['disabled']);
    }

    public function testDecodeArray(): void
    {
        $yaml = "- 1\n- 2\n- 3";
        $result = Yaml::decode($yaml, true);

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
        $result = Yaml::decode(Yaml::encode($data), true);

        Assert::type('array', $result);
        Assert::same(5432, $result['database']['port']);
    }

    public function testValidate(): void
    {
        $validYaml = "name: John\nage: 30";
        Assert::true(Yaml::validate($validYaml));

        $invalidYaml = "invalid: yaml: {] syntax";
        Assert::false(Yaml::validate($invalidYaml));
    }
}

(new YamlDecodeTest())->run();
