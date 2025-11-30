<?php

declare(strict_types=1);

namespace Advandz\Notation\Tests;

use Advandz\Notation\Csv;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * Tests for Csv::decode() method
 */
class CsvDecodeTest extends TestCase
{
    public function testDecodeSimpleCsv(): void
    {
        $csv = "name,age,city\nJohn,30,London";
        $result = Csv::decode($csv);

        Assert::type('object', $result[0]);
        Assert::same('John', $result[0]->name);
        Assert::same(30, $result[0]->age);
    }

    public function testDecodeAsArray(): void
    {
        $csv = "name,age,city\nJohn,30,London";
        $result = Csv::decode($csv, true);

        Assert::type('array', $result);
        Assert::same('John', $result[0]['name']);
        Assert::same(30, $result[0]['age']);
    }

    public function testDecodeArray(): void
    {
        $csv = "name,age,city\nJohn,30,London";
        $result = Csv::decode($csv, true);

        Assert::type('array', $result);
        Assert::same(["name" => "John", "age" => 30, "city" => "London"], $result[0]);
    }

    public function testRoundTrip(): void
    {
        $data = [
            ["name" => "John", "age" => 30, "city" => "London"],
            ["name" => "Jane", "age" => 25, "city" => "Madrid"],
        ];
        $result = Csv::decode(Csv::encode($data), true);

        Assert::type('array', $result);
        Assert::same('Jane', $result[1]['name']);
    }

    public function testValidate(): void
    {
        $validCsv = "name,age,city\nJohn,30,London";
        Assert::true(Csv::validate($validCsv));

        $invalidCsv = "name,,,,,age\n{John,30,London}";
        Assert::false(Csv::validate($invalidCsv));
    }
}

(new CsvDecodeTest())->run();
