# Advandz Notation

![tests](https://github.com/advandz/notation/actions/workflows/tests.yml/badge.svg)
![license](https://img.shields.io/github/license/advandz/notation)

## Introduction
Advandz Notation is a lightweight collection of wrapper classes that provide a unified API for encoding,
decoding and validating multiple data notations.

## Quick Start
Helper functions in the style of json_encode and json_decode are provided for all supported notations.
This allows fast onboarding with zero effort and without needing to learn class usage first.

### Example using helpers
```php
$json = json_encode(['hello' => 'world']);
$data = json_decode($json, true);

$neon = neon_encode(['hello' => 'world']);
$data = neon_decode($neon, true);
```

The same helper naming convention is available for all notations:

| Encode Helper | Decode Helper |
|---------------|---------------|
| csv_encode    | csv_decode    |
| json_encode   | json_decode   |
| yaml_encode   | yaml_decode   |
| toml_encode   | toml_decode   |
| neon_encode   | neon_decode   |
| php_encode    | php_decode    |
| toon_encode   | toon_decode   |

## Supported Notations
It brings support for multiple notation formats together under one unified API, eliminating the need to learn a
different workflow for every standard.

Whether you prefer CSV, JSON, YAML, TOML, NEON, PHP serialization, or TOON notation, the package provides
full support across all of them.

| Class                   | Notation            |
|-------------------------|---------------------|
| `Advandz\Notation\Csv`  | CSV                 |
| `Advandz\Notation\Json` | JSON                |
| `Advandz\Notation\Neon` | NEON                |
| `Advandz\Notation\Php`  | PHP (serialization) |
| `Advandz\Notation\Toml` | TOML                |
| `Advandz\Notation\Toon` | TOON                |
| `Advandz\Notation\Yaml` | YAML                |

Each one of the notation class exposes the same public and standardized static API:

```php
public static function encode(mixed $data, int $flags = 0, int $depth = 512): ?string;
public static function decode(mixed $data, bool $associative = false, int $flags = 0, int $depth = 512): mixed;
public static function validate(string $data): bool;
````

## Contributing

Thank you for considering contributing to this project! You can read the [Contribution Guide](CONTRIBUTING.md).

## Code of Conduct

This project follows a Code of Conduct that all community members and contributors are expected to adhere to.
See **[CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md)**.

## License

This project is open-source and available under the **MIT License**.