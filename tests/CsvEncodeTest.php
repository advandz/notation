<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Csv;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Csv::encode() method
 */
class CsvEncodeTest extends TestCase
{
    public function testEncodeSimpleArray(): void
    {
        $data = [
            ["name" => "John", "age" => 30, "city" => "London"],
            ["name" => "Jane", "age" => 25, "city" => "Madrid"],
        ];
        $result = Csv::encode($data);

        Assert::type('string', $result);
        Assert::contains('name,age,city', $result);
        Assert::contains('John,30,London', $result);
        Assert::contains('Jane,25,Madrid', $result);
    }

    public function testEncodeWithObjects(): void
    {
        $obj1 = (object)["name" => "John", "age" => 30, "city" => "London"];
        $obj2 = (object)["name" => "Jane", "age" => 25, "city" => "Madrid"];
        $data = [$obj1, $obj2];

        $result = Csv::encode($data);

        Assert::type('string', $result);
        Assert::contains('name,age,city', $result);
        Assert::contains('John,30,London', $result);
    }

    public function testEncodeEmptyArray(): void
    {
        $data = [[]];
        $result = Csv::encode($data);

        Assert::type('string', $result);
    }

    public function testEncodeScalarThrowsError(): void
    {
        $data = "scalar value";
        $result = Csv::encode($data);

        Assert::null($result);
    }

    public function testEncodeScalarWithThrowOnError(): void
    {
        Assert::exception(function () {
            Csv::encode("scalar", Csv::THROW_ON_ERROR);
        }, \Advandz\Notation\Exception\Csv::class);
    }

    public function testEncodeRowWithScalarThrowsError(): void
    {
        $data = [
            ["name" => "John", "age" => 30],
            "invalid scalar row",
        ];
        $result = Csv::encode($data);

        Assert::null($result);
    }

    public function testEncodeRowWithScalarWithThrowOnError(): void
    {
        Assert::exception(function () {
            $data = [
                ["name" => "John", "age" => 30],
                "invalid scalar row",
            ];
            Csv::encode($data, Csv::THROW_ON_ERROR);
        }, \Advandz\Notation\Exception\Csv::class);
    }

    public function testEncodeNumericValues(): void
    {
        $data = [
            ["id" => 1, "price" => 99, "quantity" => 5],
            ["id" => 2, "price" => 150, "quantity" => 3],
        ];
        $result = Csv::encode($data);

        Assert::type('string', $result);
        Assert::contains('1,99,5', $result);
        Assert::contains('2,150,3', $result);
    }

    public function testEncodeMixedTypes(): void
    {
        $data = [
            ["name" => "Product A", "price" => 99, "available" => true],
            ["name" => "Product B", "price" => 150, "available" => false],
        ];
        $result = Csv::encode($data);

        Assert::type('string', $result);
        Assert::contains('Product A', $result);
        Assert::contains('Product B', $result);
    }
}

(new CsvEncodeTest())->run();