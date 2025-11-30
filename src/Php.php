<?php

declare(strict_types=1);

namespace Advandz\Notation;

use Advandz\Notation\Common\Notation;

/**
 * PHP serialization notation wrapper class
 *
 * Provides a unified interface for encoding and decoding data using PHP's native
 * serialize() and unserialize() functions.
 *
 * @copyright Copyright (c) 2025, Advandz Technologies, LLC
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.advandz.com/ Advandz
 */
class Php extends Notation
{
    /**
     * Encode data to PHP serialization format
     *
     * Uses PHP's native serialize() function to convert data structures into
     * a storable string representation.
     *
     * @param mixed $data The data to encode (arrays, objects, primitives)
     * @param int $flags Encoding flags (THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512)
     * @return string|null Encoded PHP serialized string, or null on failure
     */
    public static function encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        return parent::encode($data, $flags, $depth);
    }

    /**
     * Decode PHP serialized string to PHP data structures
     *
     * Uses PHP's native unserialize() function to convert serialized strings
     * back into PHP data structures.
     *
     * @param mixed $data The PHP serialized string to decode
     * @param bool $associative When true, return arrays instead of objects (default: false)
     * @param int $flags Decoding flags (THROW_ON_ERROR)
     * @param int $depth Maximum nesting depth (default: 512)
     * @return mixed Decoded data, or null on failure
     */
    public static function decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        return parent::decode($data, $associative, $flags, $depth);
    }
}