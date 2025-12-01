<?php

declare(strict_types=1);

namespace Advandz\Notation\Common;

use Nette\StaticClass;

/**
 * Abstract base class for notation implementations
 *
 * Provides common functionality and constants for all notation format implementations.
 * Defines the standard API for encoding, decoding, validation, and error handling
 * across different notation formats.
 *
 * @copyright Copyright (c) 2025, Advandz Technologies, LLC
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.advandz.com/ Advandz
 */
abstract class Notation implements NotationInterface
{
    use StaticClass;

    /**
     * @var int Flag to throw exceptions on errors instead of returning null
     */
    const THROW_ON_ERROR = 1;

    /**
     * @var int Flag to enable pretty-print formatting with indentation
     */
    const PRETTY_PRINT = 2;

    /**
     * @var int Flag to force objects with numeric keys in encoded output
     */
    const FORCE_OBJECT = 4;

    /**
     * @var int Flag to force associative arrays in decoded output
     */
    const FORCE_ARRAY = 8;

    /**
     * @var int Flag to output unescaped unicode characters
     */
    const UNESCAPED_UNICODE = 16;

    /**
     * @var \Throwable|null Stores the last error that occurred
     */
    protected static $error;

    /**
     * Returns the MIME type used for files associated to the notation format
     *
     * @return string The mime type for the notation format
     */
    public static function mime(): string
    {
        $format = strtolower(
            (new \ReflectionClass(static::class))->getShortName()
        );

        return ($format !== 'php') ? 'application/' . trim($format, '-') : 'text/plain';
    }

    /**
     * Returns the extension used for files associated to the notation format
     *
     * @return string The mime type for the notation format
     */
    public static function extension(): string
    {
        $format = strtolower(
            (new \ReflectionClass(static::class))->getShortName()
        );

        return ($format !== 'php') ? trim($format, '-') : 'txt';
    }

    /**
     * Encode data to notation format
     *
     * Default implementation uses PHP's serialize() function. Child classes should
     * override this method to provide format-specific encoding.
     *
     * @param mixed $data The data to encode
     * @param int $flags Encoding flags (THROW_ON_ERROR, PRETTY_PRINT, etc.)
     * @param int $depth Maximum nesting depth
     * @return string|null Encoded string, or null on failure
     */
    public static function encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        try {
            return serialize($data);
        } catch (\Throwable $exception) {
            static::$error = $exception;

            if ($flags & static::THROW_ON_ERROR) {
                static::thrownError(static::$error);
            }
        }

        return null;
    }

    /**
     * Decode notation string to PHP data structures
     *
     * Default implementation uses PHP's unserialize() function. Child classes should
     * override this method to provide format-specific decoding.
     *
     * @param mixed $data The notation string to decode
     * @param bool $associative When true, return arrays instead of objects
     * @param int $flags Decoding flags (FORCE_ARRAY, THROW_ON_ERROR, etc.)
     * @param int $depth Maximum nesting depth
     * @return mixed Decoded data, or null on failure
     */
    public static function decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        try {
            if ((($flags & static::FORCE_ARRAY) || $associative) && !is_scalar(unserialize($data))) {
                return (array) unserialize($data, ['max_depth' => $depth]);
            }

            return is_scalar(unserialize($data))
                ? unserialize($data)
                : (object) unserialize($data, ['max_depth' => $depth]);
        } catch (\Throwable $exception) {
            static::$error = $exception;

            if ($flags & static::THROW_ON_ERROR) {
                static::thrownError(static::$error);
            }
        }

        return null;
    }

    /**
     * Validate notation string
     *
     * Validates a notation string by attempting to decode and re-encode it,
     * ensuring the round-trip produces identical output.
     *
     * @param string $data The notation string to validate
     * @return bool True if valid, false otherwise
     */
    public static function validate(string $data): bool
    {
        try {
            $decoded = @static::decode($data);
            $encoded = @static::encode($decoded);

            return
                trim($data) === $encoded
                || (
                    !empty($decoded) && (get_debug_type($decoded) == get_debug_type(@static::decode($encoded)))
                );
        } catch (\Throwable $exception) {
            static::$error = $exception;

            return false;
        }
    }

    /**
     * Get the last error that occurred
     *
     * Returns the last exception that was caught during encode/decode operations.
     *
     * @return \Throwable|null The last error, or null if no error occurred
     */
    public static function lastError(): ?\Throwable
    {
        return static::$error;
    }

    /**
     * Throw an error
     *
     * Throws an exception based on the provided error. If a Throwable is provided,
     * it attempts to find a format-specific exception class. If a string is provided,
     * throws a generic Exception.
     *
     * @param \Throwable|string $exception The error to throw
     * @throws \Exception
     */
    public static function thrownError(\Throwable|string $exception): void
    {
        if (is_string($exception)) {
            $exception = new \Exception($exception, 500);
        } else {
            $class = (new \ReflectionClass(static::class))->getShortName();
            $throwable = 'Advandz\\Notation\\Exception\\' . $class;
            if (!class_exists($throwable)) {
                $throwable = '\\Exception';
            }

            $exception = new $throwable($exception->getMessage(), $exception->getCode());
        }

        static::$error = $exception;

        throw $exception;
    }
}