<?php

declare(strict_types=1);

namespace Advandz\Toon\Tests;

use Advandz\Notation\Json;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Json::encode() method
 */
class JsonEncodeTest extends TestCase
{
    public function testEncodeSimpleObject(): void
    {
        $data = (object)["name" => "John", "age" => 30, "city" => "London"];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('"name":"John"', $result);
        Assert::contains('"age":30', $result);
        Assert::contains('"city":"London"', $result);
    }

    public function testEncodeSimpleArray(): void
    {
        $data = ["name" => "John", "age" => 30, "city" => "London"];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('"name":"John"', $result);
        Assert::contains('"age":30', $result);
    }

    public function testEncodeIndexedArray(): void
    {
        $data = ["apple", "banana", "cherry"];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::same('["apple","banana","cherry"]', $result);
    }

    public function testEncodeArrayOfObjects(): void
    {
        $data = [
            (object)["name" => "John", "age" => 30],
            (object)["name" => "Jane", "age" => 25],
        ];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('"John"', $result);
        Assert::contains('"Jane"', $result);
    }

    public function testEncodeWithPrettyPrint(): void
    {
        $data = (object)["name" => "John", "age" => 30];
        $result = Json::encode($data, Json::PRETTY_PRINT);

        Assert::type('string', $result);
        Assert::contains("\n", $result);
        Assert::contains('    ', $result); // Indentation
    }

    public function testEncodeWithForceObject(): void
    {
        $data = ["apple", "banana", "cherry"];
        $result = Json::encode($data, Json::FORCE_OBJECT);

        Assert::type('string', $result);
        Assert::contains('"0":"apple"', $result);
        Assert::contains('"1":"banana"', $result);
    }

    public function testEncodeWithUnescapedUnicode(): void
    {
        $data = (object)["text" => "Hello 🌍"];
        $result = Json::encode($data, Json::UNESCAPED_UNICODE);

        Assert::type('string', $result);
        Assert::contains('🌍', $result);
    }

    public function testEncodeNestedStructure(): void
    {
        $data = (object)[
            "user" => (object)[
                "name" => "John",
                "age" => 30
            ]
        ];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('"user":', $result);
        Assert::contains('"name":"John"', $result);
    }

    public function testEncodeNumericValues(): void
    {
        $data = (object)[
            "id" => 123,
            "price" => 99.99,
            "quantity" => 5
        ];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('"id":123', $result);
        Assert::contains('"price":99.99', $result);
        Assert::contains('"quantity":5', $result);
    }

    public function testEncodeBooleanValues(): void
    {
        $data = (object)[
            "active" => true,
            "disabled" => false
        ];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('"active":true', $result);
        Assert::contains('"disabled":false', $result);
    }

    public function testEncodeNullValue(): void
    {
        $data = (object)["value" => null];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('"value":null', $result);
    }

    public function testEncodeString(): void
    {
        $data = "Hello World";
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::same('"Hello World"', $result);
    }

    public function testEncodeNumber(): void
    {
        $data = 42;
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::same('42', $result);
    }

    public function testEncodeBoolean(): void
    {
        $data = true;
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::same('true', $result);
    }

    public function testEncodeNull(): void
    {
        $data = null;
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::same('null', $result);
    }

    public function testEncodeEmptyObject(): void
    {
        $data = (object)[];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::same('{}', $result);
    }

    public function testEncodeEmptyArray(): void
    {
        $data = [];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::same('[]', $result);
    }

    public function testRoundTrip(): void
    {
        $data = (object)[
            "name" => "John",
            "age" => 30,
            "city" => "London"
        ];
        $encoded = Json::encode($data);
        $decoded = Json::decode($encoded);

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
        $encoded = Json::encode($data);
        $decoded = Json::decode($encoded, true);

        Assert::type('array', $decoded);
        Assert::same('John', $decoded[0]['name']);
        Assert::same('Jane', $decoded[1]['name']);
    }

    public function testEncodeMixedTypes(): void
    {
        $data = (object)[
            "string" => "hello",
            "number" => 42,
            "float" => 3.14,
            "boolean" => true,
            "null" => null,
            "array" => [1, 2, 3],
            "object" => (object)["nested" => "value"]
        ];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('"string":"hello"', $result);
        Assert::contains('"number":42', $result);
        Assert::contains('"boolean":true', $result);
        Assert::contains('"null":null', $result);
    }

    public function testEncodeSpecialCharacters(): void
    {
        $data = (object)["text" => "Hello\nWorld\t!"];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('\\n', $result);
        Assert::contains('\\t', $result);
    }

    public function testEncodeQuotes(): void
    {
        $data = (object)["text" => 'He said "Hello"'];
        $result = Json::encode($data);

        Assert::type('string', $result);
        Assert::contains('\\"', $result);
    }
}

(new JsonEncodeTest())->run();