<?php

declare(strict_types=1);

/**
 * Helper functions for notation encoding and decoding
 *
 * These functions offer a convenient procedural interface as an alternative to
 * the object-oriented API.
 *
 * @copyright Copyright (c) 2025, Advandz Technologies, LLC
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.advandz.com/ Advandz
 */

if (!function_exists('csv_encode')) {
    /**
     * Encode data to CSV format
     *
     * @param mixed $data The data to encode
     * @param int $flags Encoding flags
     * @param int $depth Maximum nesting depth
     * @return string|null Encoded CSV string, or null on failure
     */
    function csv_encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        return \Advandz\Notation\Csv::encode($data, $flags, $depth);
    }
}

if (!function_exists('csv_decode')) {
    /**
     * Decode CSV string to PHP data structures
     *
     * @param mixed $data The CSV string to decode
     * @param bool $associative When true, return arrays instead of objects
     * @param int $flags Decoding flags
     * @param int $depth Maximum nesting depth
     * @return mixed Decoded data, or null on failure
     */
    function csv_decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        return \Advandz\Notation\Csv::decode($data, $associative, $flags, $depth);
    }
}

if (!function_exists('csv_validate')) {
    /**
     * Validate CSV string
     *
     * @param string $data The CSV string to validate
     * @return bool True if valid, false otherwise
     */
    function csv_validate(string $data): bool
    {
        return \Advandz\Notation\Csv::validate($data);
    }
}

if (!function_exists('csv_last_error')) {
    /**
     * Get the error code from the last CSV operation
     *
     * @return int The error code
     */
    function csv_last_error(): int
    {
        return \Advandz\Notation\Csv::lastError()->getCode();
    }
}

if (!function_exists('csv_last_error_msg')) {
    /**
     * Get the error message from the last CSV operation
     *
     * @return string The error message
     */
    function csv_last_error_msg(): string
    {
        return \Advandz\Notation\Csv::lastError()->getMessage();
    }
}

if (!function_exists('json_encode')) {
    /**
     * Encode data to JSON format
     *
     * @param mixed $data The data to encode
     * @param int $flags Encoding flags
     * @param int $depth Maximum nesting depth
     * @return string|null Encoded JSON string, or null on failure
     */
    function json_encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        return \Advandz\Notation\Json::encode($data, $flags, $depth);
    }
}

if (!function_exists('json_decode')) {
    /**
     * Decode JSON string to PHP data structures
     *
     * @param mixed $data The JSON string to decode
     * @param bool $associative When true, return arrays instead of objects
     * @param int $flags Decoding flags
     * @param int $depth Maximum nesting depth
     * @return mixed Decoded data, or null on failure
     */
    function json_decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        return \Advandz\Notation\Json::decode($data, $associative, $flags, $depth);
    }
}

if (!function_exists('json_validate')) {
    /**
     * Validate JSON string
     *
     * @param string $data The JSON string to validate
     * @return bool True if valid, false otherwise
     */
    function json_validate(string $data): bool
    {
        return \Advandz\Notation\Json::validate($data);
    }
}

if (!function_exists('json_last_error')) {
    /**
     * Get the error code from the last JSON operation
     *
     * @return int The error code
     */
    function json_last_error(): int
    {
        return \Advandz\Notation\Json::lastError()->getCode();
    }
}

if (!function_exists('json_last_error_msg')) {
    /**
     * Get the error message from the last JSON operation
     *
     * @return string The error message
     */
    function json_last_error_msg(): string
    {
        return \Advandz\Notation\Json::lastError()->getMessage();
    }
}

if (!function_exists('neon_encode')) {
    /**
     * Encode data to NEON format
     *
     * @param mixed $data The data to encode
     * @param int $flags Encoding flags
     * @param int $depth Maximum nesting depth
     * @return string|null Encoded JSON string, or null on failure
     */
    function neon_encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        return \Advandz\Notation\Neon::encode($data, $flags, $depth);
    }
}

if (!function_exists('neon_decode')) {
    /**
     * Decode NEON string to PHP data structures
     *
     * @param mixed $data The NEON string to decode
     * @param bool $associative When true, return arrays instead of objects
     * @param int $flags Decoding flags
     * @param int $depth Maximum nesting depth
     * @return mixed Decoded data, or null on failure
     */
    function neon_decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        return \Advandz\Notation\Neon::decode($data, $associative, $flags, $depth);
    }
}

if (!function_exists('neon_validate')) {
    /**
     * Validate NEON string
     *
     * @param string $data The NEON string to validate
     * @return bool True if valid, false otherwise
     */
    function neon_validate(string $data): bool
    {
        return \Advandz\Notation\Neon::validate($data);
    }
}

if (!function_exists('neon_last_error')) {
    /**
     * Get the error code from the last NEON operation
     *
     * @return int The error code
     */
    function neon_last_error(): int
    {
        return \Advandz\Notation\Neon::lastError()->getCode();
    }
}

if (!function_exists('neon_last_error_msg')) {
    /**
     * Get the error message from the last NEON operation
     *
     * @return string The error message
     */
    function neon_last_error_msg(): string
    {
        return \Advandz\Notation\Neon::lastError()->getMessage();
    }
}

if (!function_exists('php_encode')) {
    /**
     * Encode data to PHP serialization format
     *
     * @param mixed $data The data to encode
     * @param int $flags Encoding flags
     * @param int $depth Maximum nesting depth
     * @return string|null Encoded PHP string, or null on failure
     */
    function php_encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        return \Advandz\Notation\Php::encode($data, $flags, $depth);
    }
}

if (!function_exists('php_decode')) {
    /**
     * Decode PHP serialized string to PHP data structures
     *
     * @param mixed $data The PHP serialized string to decode
     * @param bool $associative When true, return arrays instead of objects
     * @param int $flags Decoding flags
     * @param int $depth Maximum nesting depth
     * @return mixed Decoded data, or null on failure
     */
    function php_decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        return \Advandz\Notation\Php::decode($data, $associative, $flags, $depth);
    }
}

if (!function_exists('php_validate')) {
    /**
     * Validate PHP serialized string
     *
     * @param string $data The PHP serialized string to validate
     * @return bool True if valid, false otherwise
     */
    function php_validate(string $data): bool
    {
        return \Advandz\Notation\Php::validate($data);
    }
}

if (!function_exists('php_last_error')) {
    /**
     * Get the error code from the last PHP operation
     *
     * @return int The error code
     */
    function php_last_error(): int
    {
        return \Advandz\Notation\Php::lastError()->getCode();
    }
}

if (!function_exists('php_last_error_msg')) {
    /**
     * Get the error message from the last PHP operation
     *
     * @return string The error message
     */
    function php_last_error_msg(): string
    {
        return \Advandz\Notation\Php::lastError()->getMessage();
    }
}

if (!function_exists('toon_encode')) {
    /**
     * Encode data to TOON format
     *
     * @param mixed $data The data to encode
     * @param int $flags Encoding flags
     * @param int $depth Maximum nesting depth
     * @return string|null Encoded TOON string, or null on failure
     */
    function toon_encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        return \Advandz\Notation\Toon::encode($data, $flags, $depth);
    }
}

if (!function_exists('toon_decode')) {
    /**
     * Decode TOON string to PHP data structures
     *
     * @param mixed $data The TOON string to decode
     * @param bool $associative When true, return arrays instead of objects
     * @param int $flags Decoding flags
     * @param int $depth Maximum nesting depth
     * @return mixed Decoded data, or null on failure
     */
    function toon_decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        return \Advandz\Notation\Toon::decode($data, $associative, $flags, $depth);
    }
}

if (!function_exists('toon_validate')) {
    /**
     * Validate TOON string
     *
     * @param string $data The TOON string to validate
     * @return bool True if valid, false otherwise
     */
    function toon_validate(string $data): bool
    {
        return \Advandz\Notation\Toon::validate($data);
    }
}

if (!function_exists('toon_last_error')) {
    /**
     * Get the error code from the last TOON operation
     *
     * @return int The error code
     */
    function toon_last_error(): int
    {
        return \Advandz\Notation\Toon::lastError()->getCode();
    }
}

if (!function_exists('toon_last_error_msg')) {
    /**
     * Get the error message from the last TOON operation
     *
     * @return string The error message
     */
    function toon_last_error_msg(): string
    {
        return \Advandz\Notation\Toon::lastError()->getMessage();
    }
}

if (!function_exists('yaml_encode')) {
    /**
     * Encode data to YAML format
     *
     * @param mixed $data The data to encode
     * @param int $flags Encoding flags
     * @param int $depth Maximum nesting depth
     * @return string|null Encoded YAML string, or null on failure
     */
    function yaml_encode(mixed $data, int $flags = 0, int $depth = 512): ?string
    {
        return \Advandz\Notation\Yaml::encode($data, $flags, $depth);
    }
}

if (!function_exists('yaml_decode')) {
    /**
     * Decode YAML string to PHP data structures
     *
     * @param mixed $data The YAML string to decode
     * @param bool $associative When true, return arrays instead of objects
     * @param int $flags Decoding flags
     * @param int $depth Maximum nesting depth
     * @return mixed Decoded data, or null on failure
     */
    function yaml_decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed
    {
        return \Advandz\Notation\Yaml::decode($data, $associative, $flags, $depth);
    }
}

if (!function_exists('yaml_validate')) {
    /**
     * Validate YAML string
     *
     * @param string $data The YAML string to validate
     * @return bool True if valid, false otherwise
     */
    function yaml_validate(string $data): bool
    {
        return \Advandz\Notation\Yaml::validate($data);
    }
}

if (!function_exists('yaml_last_error')) {
    /**
     * Get the error code from the last YAML operation
     *
     * @return int The error code
     */
    function yaml_last_error(): int
    {
        return \Advandz\Notation\Yaml::lastError()->getCode();
    }
}

if (!function_exists('yaml_last_error_msg')) {
    /**
     * Get the error message from the last YAML operation
     *
     * @return string The error message
     */
    function yaml_last_error_msg(): string
    {
        return \Advandz\Notation\Yaml::lastError()->getMessage();
    }
}
