<?php

declare(strict_types=1);

namespace Advandz\Notation;

use Advandz\Notation\Common\Notation;
use League\Csv\Reader as CsvDecoder;
use League\Csv\Writer as CsvEncoder;

/**
 * CSV (Comma-Separated values) notation wrapper class
 *
 * Provides a unified interface for encoding and decoding JSON data.
 *
 * @copyright Copyright (c) 2025, Advandz Technologies, LLC
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.advandz.com/ Advandz
 */
class Csv extends Notation
{
    /**
     * Encode data to CSV format
     *
     * Converts PHP data structures into JSON string representation with support for
     * various formatting options via flags.
     *
     * @param mixed $data The data to encode (arrays, objects, primitives)
     * @param int $flags Encoding flags (THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512)
     * @return string|null Encoded JSON string, or null on failure
     */
    public static function encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        try {
            if (is_scalar($data)) {
                throw new Exception\CsvException('The data to encode must not be a scalar value.');
            }

            // Fetch headers
            $records = (array) $data;
            $headers = array_keys((array) reset($records));

            // Encode array
            foreach ($records as $row => &$record) {
                if (!is_scalar($record)) {
                    $record = (array) $record;
                } else {
                    throw new Exception\CsvException("The row #{$row} is a scalar value.");
                }
            }

            $csv = CsvEncoder::fromString();
            $csv->insertOne($headers);
            $csv->insertAll($records);

            return $csv->toString();
        } catch (\Throwable $exception) {
            self::$error = $exception;

            if ($flags & self::THROW_ON_ERROR) {
                self::thrownError(self::$error);
            }
        }

        return null;
    }

    /**
     * Decode CSV string to PHP data structures
     *
     * Parses a CSV string and converts it into PHP arrays or objects.
     *
     * @param mixed $data The CSV string to decode
     * @param bool $associative When true, return arrays instead of objects (default: false)
     * @param int $flags Decoding flags (FORCE_ARRAY, THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512)
     * @return mixed Decoded data, or null on failure
     */
    public static function decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        try {
            $csv = CsvDecoder::fromString($data);
            $csv->setHeaderOffset(0);

            $result = array_values([...$csv->getRecords()]);
            foreach ($result as &$row) {
                foreach ($row as &$value) {
                    if (is_numeric($value) && !is_float($value) && !str_contains($value, '.')) {
                        $value = (int) $value;
                    }
                }

                $row = (($flags & self::FORCE_ARRAY) || $associative)
                    ? $row
                    : (object) $row;
            }

            return $result;
        } catch (\Throwable $exception) {
            self::$error = $exception;

            if ($flags & self::THROW_ON_ERROR) {
                self::thrownError(self::$error);
            }
        }

        return null;
    }
}
