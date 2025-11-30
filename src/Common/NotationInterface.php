<?php

declare(strict_types=1);

namespace Advandz\Notation\Common;

/**
 * Notation interface
 *
 * Defines the standard API that all notation format implementations must provide.
 * This ensures consistent encoding, decoding, validation, and error handling across
 * different notation formats (JSON, TOON, etc.).
 *
 * @copyright Copyright (c) 2025, Advandz Technologies, LLC
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.advandz.com/ Advandz
 */
interface NotationInterface
{
    /**
     * Returns the MIME type used for files associated to the notation format
     *
     * @return string The mime type for the notation format
     */
    public static function mime(): string;

    /**
     * Encode data to notation format
     *
     * @param mixed $data The data to encode
     * @param int $flags Encoding flags
     * @param int $depth Maximum nesting depth
     * @return string|null Encoded string, or null on failure
     */
    public static function encode(mixed $data, int $flags = 0, int $depth = 512): ?string;

    /**
     * Decode notation string to PHP data structures
     *
     * @param mixed $data The notation string to decode
     * @param bool $associative When true, return arrays instead of objects
     * @param int $flags Decoding flags
     * @param int $depth Maximum nesting depth
     * @return mixed Decoded data, or null on failure
     */
    public static function decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed;

    /**
     * Validate notation string
     *
     * @param string $data The notation string to validate
     * @return bool True if valid, false otherwise
     */
    public static function validate(string $data): bool;

    /**
     * Get the last error that occurred
     *
     * @return object|null The last error, or null if no error occurred
     */
    public static function lastError(): ?object;
}