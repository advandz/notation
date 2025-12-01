<?php

declare(strict_types=1);

namespace Advandz\Notation;

use Advandz\Notation\Common\Notation;
use Yosymfony\Toml\Toml as TomlNotation;
use Yosymfony\Toml\TomlBuilder;

/**
 * TOML (Tom's Obvious Minimal Language) notation wrapper class
 *
 * Provides a unified interface for encoding and decoding TOML data.
 *
 * @copyright Copyright (c) 2025, Advandz Technologies, LLC
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.advandz.com/ Advandz
 */
class Toml extends Notation
{
    /**
     * Handle static method calls
     *
     * Forwards any unrecognized static method calls to the underlying notation class.
     * This allows access to additional methods not explicitly wrapped.
     *
     * @param string $name The method name being called
     * @param array $args The arguments passed to the method
     * @return mixed The result from the called method
     */
    public static function __callStatic(string $name, array $args): mixed
    {
        return call_user_func_array([TomlNotation::class, $name], $args);
    }

    /**
     * Encode data to TOML format
     *
     * Converts PHP data structures into TOML string representation with support for
     * various formatting options via flags.
     *
     * @param mixed $data The data to encode (arrays, objects, primitives)
     * @param int $flags Encoding flags (PRETTY_PRINT, THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512)
     * @return string|null Encoded JSON string, or null on failure
     */
    public static function encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        try {
            // Recursively cast non-scalar values to arrays
            $data = self::toArray($data);

            // Create TomlBuilder instance
            $builder = new TomlBuilder();

            // Add data to builder
            self::addToBuilder($builder, $data);

            // Get TOML string
            return $builder->getTomlString();
        } catch (\Throwable $exception) {
            self::$error = $exception;

            if ($flags & self::THROW_ON_ERROR) {
                self::thrownError(self::$error);
            }
        }

        return null;
    }

    /**
     * Recursively convert non-scalar values to arrays
     *
     * @param mixed $value The value to convert
     * @return mixed The converted value
     */
    private static function toArray(mixed $value): mixed
    {
        // If scalar, return as-is
        if (is_scalar($value) || is_null($value)) {
            return $value;
        }

        // Convert objects and arrays to array
        $array = (array) $value;

        // Recursively process array values
        foreach ($array as $key => $val) {
            $array[$key] = self::toArray($val);
        }

        return $array;
    }

    /**
     * Add data to the builder
     *
     * @param TomlBuilder $builder The builder instance
     * @param array $data The data to add
     * @param string $prefix The key prefix for nested arrays
     * @return void
     */
    private static function addToBuilder(TomlBuilder $builder, array $data, string $prefix = ''): void
    {
        foreach ($data as $key => $value) {
            $fullKey = $prefix ? $prefix . '.' . $key : $key;

            if (is_array($value)) {
                // Check if it's a list of arrays (array of tables)
                if (self::isArrayOfArrays($value)) {
                    $builder->addArrayOfTable($key);
                    foreach ($value as $item) {
                        if (is_array($item)) {
                            self::addToBuilder($builder, $item, $key);
                        }
                    }
                } else {
                    // Regular table
                    $builder->addTable($key);
                    self::addToBuilder($builder, $value, $key);
                }
            } else {
                // Add value
                $builder->addValue($key, $value);
            }
        }
    }

    /**
     * Check if value is an array of arrays
     *
     * @param mixed $value The value to check
     * @return bool True if array of arrays, false otherwise
     */
    private static function isArrayOfArrays(mixed $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $item) {
            if (!is_array($item)) {
                return false;
            }
        }

        return count($value) > 0;
    }

    /**
     * Decode TOML string to PHP data structures
     *
     * Parses a TOML string and converts it into PHP arrays or objects.
     *
     * @param mixed $data The TOML string to decode
     * @param bool $associative When true, return arrays instead of objects (default: false)
     * @param int $flags Decoding flags (FORCE_ARRAY, THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512)
     * @return mixed Decoded data, or null on failure
     */
    public static function decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        try {
            if ((($flags & self::FORCE_ARRAY) || $associative) && !is_scalar(@TomlNotation::Parse($data))) {
                return (array) @TomlNotation::Parse($data, true);
            }

            return @TomlNotation::Parse($data, !(($flags & self::FORCE_ARRAY) || $associative));
        } catch (\Throwable $exception) {
            self::$error = $exception;

            if ($flags & self::THROW_ON_ERROR) {
                self::thrownError(self::$error);
            }
        }

        return null;
    }
}
