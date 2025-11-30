<?php

declare(strict_types=1);

namespace Advandz\Notation;

use Advandz\Notation\Common\Notation;
use HelgeSverre\Toon\Toon as ToonNotation;

/**
 * TOON (Token-Oriented Object Notation) wrapper class
 *
 * Provides a unified interface for encoding and decoding TOON data.
 *
 * @copyright Copyright (c) 2025, Advandz Technologies, LLC
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.advandz.com/ Advandz
 */
class Toon extends Notation
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
        return call_user_func_array([ToonNotation::class, $name], $args);
    }

    /**
     * Encode data to TOON format
     *
     * Converts PHP data structures into TOON string representation with support for
     * various formatting options via flags.
     *
     * @param mixed $data The data to encode (arrays, objects, primitives)
     * @param int $flags Encoding flags (PRETTY_PRINT for 4-space indentation, THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512, currently unused by TOON)
     * @return string|null Encoded TOON string, or null on failure
     */
    public static function encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        try {
            $options = null;
            if ($flags !== 0) {
                $options = new \HelgeSverre\Toon\EncodeOptions(
                    indent: ($flags & self::PRETTY_PRINT) ? 4 : 2
                );
            }

            return ToonNotation::encode($data, $options);
        } catch (\Throwable $exception) {
            self::$error = $exception;

            if ($flags & self::THROW_ON_ERROR) {
                self::thrownError(self::$error);
            }
        }

        return null;
    }

    /**
     * Decode TOON string to PHP data structures
     *
     * Parses a TOON string and converts it into PHP arrays or objects.
     *
     * @param mixed $data The TOON string to decode
     * @param bool $associative When true, return arrays instead of objects (default: false)
     * @param int $flags Decoding flags (FORCE_ARRAY, THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512, currently unused by TOON)
     * @return mixed Decoded data, or null on failure
     */
    public static function decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        try {
            $options = null;
            if ($flags !== 0) {
                $options = new \HelgeSverre\Toon\DecodeOptions(
                    indent: ($flags & self::PRETTY_PRINT) ? 4 : 2,
                    strict: (bool) (($flags & self::FORCE_OBJECT))
                );
            }

            if ((($flags & self::FORCE_ARRAY) || $associative) && !is_scalar(ToonNotation::decode($data, $options))) {
                return (array) ToonNotation::decode($data, $options);
            }

            return is_scalar(ToonNotation::decode($data, $options))
                ? ToonNotation::decode($data, $options)
                : (object) ToonNotation::decode($data, $options);
        } catch (\Throwable $exception) {
            self::$error = $exception;

            if ($flags & self::THROW_ON_ERROR) {
                self::thrownError(self::$error);
            }
        }

        return null;
    }
}