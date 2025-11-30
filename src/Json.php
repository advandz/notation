<?php

declare(strict_types=1);

namespace Advandz\Notation;

use Advandz\Notation\Common\Notation;
use Nette\Utils\Json as JsonNotation;

/**
 * JSON (JavaScript Object Notation) notation wrapper class
 *
 * Provides a unified interface for encoding and decoding JSON data.
 *
 * @copyright Copyright (c) 2025, Advandz Technologies, LLC
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.advandz.com/ Advandz
 */
class Json extends Notation
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
        return call_user_func_array([JsonNotation::class, $name], $args);
    }

    /**
     * Encode data to JSON format
     *
     * Converts PHP data structures into JSON string representation with support for
     * various formatting options via flags.
     *
     * @param mixed $data The data to encode (arrays, objects, primitives)
     * @param int $flags Encoding flags (PRETTY_PRINT, FORCE_OBJECT, UNESCAPED_UNICODE, THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512)
     * @return string|null Encoded JSON string, or null on failure
     */
    public static function encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        try {
            return JsonNotation::encode(
                $data,
                (bool) ($flags & self::PRETTY_PRINT),
                !((bool) ($flags & self::UNESCAPED_UNICODE)),
                false,
                (bool) ($flags & self::FORCE_OBJECT)
            );
        } catch (\Throwable $exception) {
            self::$error = $exception;

            if ($flags & self::THROW_ON_ERROR) {
                self::thrownError(self::$error);
            }
        }

        return null;
    }

    /**
     * Decode JSON string to PHP data structures
     *
     * Parses a JSON string and converts it into PHP arrays or objects.
     *
     * @param mixed $data The JSON string to decode
     * @param bool $associative When true, return arrays instead of objects (default: false)
     * @param int $flags Decoding flags (FORCE_ARRAY, THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512)
     * @return mixed Decoded data, or null on failure
     */
    public static function decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        try {
            return JsonNotation::decode(
                $data,
                ($flags & self::FORCE_ARRAY) || $associative
            );
        } catch (\Throwable $exception) {
            self::$error = $exception;

            if ($flags & self::THROW_ON_ERROR) {
                self::thrownError(self::$error);
            }
        }

        return null;
    }
}