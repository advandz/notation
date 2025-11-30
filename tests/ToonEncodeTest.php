<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Toon;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Toon::encode() method
 */
class ToonEncodeTest extends TestCase
{
    public function testEncodeSimpleObject(): void
    {
        $data = (object)["name" => "John", "age" => 30, "city" => "London"];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('name: John', $result);
        Assert::contains('age: 30', $result);
        Assert::contains('city: London', $result);
    }

    public function testEncodeSimpleArray(): void
    {
        $data = ["name" => "John", "age" => 30, "city" => "London"];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('name: John', $result);
        Assert::contains('age: 30', $result);
    }

    public function testEncodeArrayOfObjects(): void
    {
        $data = [
            (object)["name" => "John", "age" => 30],
            (object)["name" => "Jane", "age" => 25],
        ];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('John', $result);
        Assert::contains('Jane', $result);
    }

    public function testEncodeArrayOfArrays(): void
    {
        $data = [
            ["name" => "John", "age" => 30],
            ["name" => "Jane", "age" => 25],
        ];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('John', $result);
        Assert::contains('Jane', $result);
    }

    public function testEncodeWithPrettyPrint(): void
    {
        $data = (object)["name" => "John", "age" => 30];
        $result = Toon::encode($data, Toon::PRETTY_PRINT);

        Assert::type('string', $result);
        Assert::contains('name: John', $result);
    }

    public function testEncodeNestedStructure(): void
    {
        $data = (object)[
            "user" => (object)[
                "name" => "John",
                "age" => 30
            ]
        ];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('user:', $result);
        Assert::contains('name: John', $result);
    }

    public function testEncodeNumericValues(): void
    {
        $data = (object)[
            "id" => 123,
            "price" => 99.99,
            "quantity" => 5
        ];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('id: 123', $result);
        Assert::contains('price: 99.99', $result);
        Assert::contains('quantity: 5', $result);
    }

    public function testEncodeBooleanValues(): void
    {
        $data = (object)[
            "active" => true,
            "disabled" => false
        ];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('active: true', $result);
        Assert::contains('disabled: false', $result);
    }

    public function testEncodeNullValue(): void
    {
        $data = (object)["value" => null];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('value: null', $result);
    }

    public function testEncodeScalarString(): void
    {
        $data = "Hello World";
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::same("Hello World", $result);
    }

    public function testEncodeScalarNumber(): void
    {
        $data = 42;
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::same("42", $result);
    }

    public function testEncodeScalarBoolean(): void
    {
        $data = true;
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::same("true", $result);
    }

    public function testRoundTrip(): void
    {
        $data = (object)[
            "name" => "John",
            "age" => 30,
            "city" => "London"
        ];
        $encoded = Toon::encode($data);
        $decoded = Toon::decode($encoded);

        Assert::same('John', $decoded->name);
        Assert::same(30, $decoded->age);
        Assert::same('London', $decoded->city);
    }

    public function testRoundTripArray(): void
    {
        $data = [
            ["name" => "John", "age" => 30],
            ["name" => "Jane", "age" => 25],
        ];
        $encoded = Toon::encode($data);
        $decoded = Toon::decode($encoded, true);

        Assert::type('array', $decoded);
        Assert::same('John', $decoded[0]['name']);
        Assert::same('Jane', $decoded[1]['name']);
    }

    public function testEncodeEmptyObject(): void
    {
        $data = (object)[];
        $result = Toon::encode($data);

        Assert::type('string', $result);
    }

    public function testEncodeEmptyArray(): void
    {
        $data = [];
        $result = Toon::encode($data);

        Assert::type('string', $result);
    }

    public function testEncodeMixedTypes(): void
    {
        $data = (object)[
            "string" => "hello",
            "number" => 42,
            "float" => 3.14,
            "boolean" => true,
            "null" => null,
            "array" => [1, 2, 3]
        ];
        $result = Toon::encode($data);

        Assert::type('string', $result);
        Assert::contains('string: hello', $result);
        Assert::contains('number: 42', $result);
        Assert::contains('boolean: true', $result);
        Assert::contains('null: null', $result);
    }
}

(new ToonEncodeTest())->run();