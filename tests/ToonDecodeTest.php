<?php

declare(strict_types=1);

namespace Advandz\Toon\Tests;

use Advandz\Notation\Toon;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Toon::decode() method
 */
class ToonDecodeTest extends TestCase
{
    public function testDecodeSimpleObject(): void
    {
        $toon = "name: John\nage: 30\ncity: London";
        $result = Toon::decode($toon);

        Assert::type('object', $result);
        Assert::same('John', $result->name);
        Assert::same(30, $result->age);
        Assert::same('London', $result->city);
    }

    public function testDecodeAsArray(): void
    {
        $toon = "name: John\nage: 30\ncity: London";
        $result = Toon::decode($toon, true);

        Assert::type('array', $result);
        Assert::same('John', $result['name']);
        Assert::same(30, $result['age']);
        Assert::same('London', $result['city']);
    }

    public function testDecodeWithForceArray(): void
    {
        $toon = "name: John\nage: 30";
        $result = Toon::decode($toon, false, Toon::FORCE_ARRAY);

        Assert::type('array', $result);
        Assert::same('John', $result['name']);
    }

    public function testDecodeArray(): void
    {
        $toon = "[2]{name,age,city}:\n  John,30,London\n  Jane,25,Madrid";
        $result = Toon::decode($toon, true);

        Assert::type('array', $result);
        Assert::count(2, $result);
        Assert::same('John', $result[0]['name']);
        Assert::same(30, $result[0]['age']);
        Assert::same('Jane', $result[1]['name']);
        Assert::same(25, $result[1]['age']);
    }

    public function testDecodeNestedStructure(): void
    {
        $toon = "user:\n  name: John\n  age: 30";
        $result = Toon::decode($toon);

        Assert::type('object', $result);
        Assert::type('array', $result->user);
        Assert::same('John', $result->user['name']);
        Assert::same(30, $result->user['age']);
    }

    public function testDecodeNumericValues(): void
    {
        $toon = "id: 123\nprice: 99.99\nquantity: 5";
        $result = Toon::decode($toon);

        Assert::same(123, $result->id);
        Assert::same(99.99, $result->price);
        Assert::same(5, $result->quantity);
    }

    public function testDecodeBooleanValues(): void
    {
        $toon = "active: true\ndisabled: false";
        $result = Toon::decode($toon);

        Assert::true($result->active);
        Assert::false($result->disabled);
    }

    public function testDecodeNullValue(): void
    {
        $toon = "value: null";
        $result = Toon::decode($toon);

        Assert::null($result->value);
    }

    public function testDecodeEmptyString(): void
    {
        $toon = "";
        $result = Toon::decode($toon);

        Assert::null($result);
    }

    public function testRoundTrip(): void
    {
        $data = (object)[
            "name" => "John",
            "age" => 30,
            "city" => "London"
        ];
        $encoded = Toon::encode($data);
        $result = Toon::decode($encoded);

        Assert::type('object', $result);
        Assert::same('John', $result->name);
        Assert::same(30, $result->age);
        Assert::same('London', $result->city);
    }

    public function testValidate(): void
    {
        $validToon = "name: John\nage: 30\ncity: London";
        Assert::true(Toon::validate($validToon));

        $invalidToon = "name John\nage 30\ncity London";
        Assert::false(Toon::validate($invalidToon));
    }
}

(new ToonDecodeTest())->run();