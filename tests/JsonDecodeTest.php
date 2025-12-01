<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Json;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Json::decode() method
 */
class JsonDecodeTest extends TestCase
{
    public function testDecodeSimpleObject(): void
    {
        $json = '{"name":"John","age":30,"city":"London"}';
        $result = Json::decode($json);

        Assert::type('object', $result);
        Assert::same('John', $result->name);
        Assert::same(30, $result->age);
        Assert::same('London', $result->city);
    }

    public function testDecodeAsArray(): void
    {
        $json = '{"name":"John","age":30,"city":"London"}';
        $result = Json::decode($json, true);

        Assert::type('array', $result);
        Assert::same('John', $result['name']);
        Assert::same(30, $result['age']);
        Assert::same('London', $result['city']);
    }

    public function testDecodeWithForceArray(): void
    {
        $json = '{"name":"John","age":30}';
        $result = Json::decode($json, false, Json::FORCE_ARRAY);

        Assert::type('array', $result);
        Assert::same('John', $result['name']);
        Assert::same(30, $result['age']);
    }

    public function testDecodeArray(): void
    {
        $json = '[{"name":"John","age":30},{"name":"Jane","age":25}]';
        $result = Json::decode($json, true);

        Assert::type('array', $result);
        Assert::count(2, $result);
        Assert::same('John', $result[0]['name']);
        Assert::same(30, $result[0]['age']);
        Assert::same('Jane', $result[1]['name']);
        Assert::same(25, $result[1]['age']);
    }

    public function testDecodeNestedStructure(): void
    {
        $json = '{"user":{"name":"John","age":30}}';
        $result = Json::decode($json);

        Assert::type('object', $result);
        Assert::type('object', $result->user);
        Assert::same('John', $result->user->name);
        Assert::same(30, $result->user->age);
    }

    public function testDecodeNumericValues(): void
    {
        $json = '{"id":123,"price":99.99,"quantity":5}';
        $result = Json::decode($json);

        Assert::same(123, $result->id);
        Assert::same(99.99, $result->price);
        Assert::same(5, $result->quantity);
    }

    public function testDecodeBooleanValues(): void
    {
        $json = '{"active":true,"disabled":false}';
        $result = Json::decode($json);

        Assert::true($result->active);
        Assert::false($result->disabled);
    }

    public function testDecodeNullValue(): void
    {
        $json = '{"value":null}';
        $result = Json::decode($json);

        Assert::null($result->value);
    }

    public function testDecodeString(): void
    {
        $json = '"Hello World"';
        $result = Json::decode($json);

        Assert::same("Hello World", $result);
    }

    public function testDecodeNumber(): void
    {
        $json = '42';
        $result = Json::decode($json);

        Assert::same(42, $result);
    }

    public function testDecodeBoolean(): void
    {
        $json = 'true';
        $result = Json::decode($json);

        Assert::true($result);
    }

    public function testDecodeNull(): void
    {
        $json = 'null';
        $result = Json::decode($json);

        Assert::null($result);
    }

    public function testDecodeEmptyObject(): void
    {
        $json = '{}';
        $result = Json::decode($json);

        Assert::type('object', $result);
    }

    public function testDecodeEmptyArray(): void
    {
        $json = '[]';
        $result = Json::decode($json, true);

        Assert::type('array', $result);
        Assert::count(0, $result);
    }

    public function testDecodeInvalidJsonReturnsNull(): void
    {
        $invalidJson = '{invalid json}';
        $result = Json::decode($invalidJson);

        Assert::null($result);
    }

    public function testDecodeInvalidJsonWithThrowOnError(): void
    {
        Assert::exception(function () {
            $invalidJson = '{invalid json}';
            Json::decode($invalidJson, false, Json::THROW_ON_ERROR);
        }, \Advandz\Notation\Exception\JsonException::class);
    }

    public function testDecodeUnicodeString(): void
    {
        $json = '{"text":"Hello 🌍"}';
        $result = Json::decode($json);

        Assert::same("Hello 🌍", $result->text);
    }

    public function testDecodeEscapedCharacters(): void
    {
        $json = '{"text":"Hello\\nWorld"}';
        $result = Json::decode($json);

        Assert::same("Hello\nWorld", $result->text);
    }

    public function testRoundTrip(): void
    {
        $data = (object)[
            "name" => "John",
            "age" => 30,
            "city" => "London"
        ];
        $encoded = Json::encode($data);
        $result = Json::decode($encoded);

        Assert::type('object', $result);
        Assert::same('John', $result->name);
        Assert::same(30, $result->age);
        Assert::same('London', $result->city);
    }

    public function testValidate(): void
    {
        $validJson = '{"name":"John","age":30}';
        Assert::true(Json::validate($validJson));

        $invalidJson = '{name:John,age:30}';
        Assert::false(Json::validate($invalidJson));
    }
}

(new JsonDecodeTest())->run();