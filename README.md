# CliColorizer

Lightweight PHP7 CLI output colorizer

- Available via `composer require `[**`wilensky/cli-colorizer`**](https://packagist.org/packages/wilensky/cli-colorizer)
- **PHP7** compliant
- **PSR2** compliant
- Lightweight
- Documented
- Compatible with native linux **`tail`** and **`cat`** commands

# Usage

For ease of use `CliColorizer` can/should be aliased with help of `use` statement.

```php
<?php

use Wilensky/CliColorizer as WCC;
```

## Changing text color

### Regular method

```php
echo WCC::fgYellow('YoHoHo').PHP_EOL; // YoHoHo will be yellowed on default background
```

> All available foregroung color `@method`s are listed under the class docblock with `fg*` prefix.

### Advanced method

```php
$answer = true;
$isOk = $answer === true;

echo WCC::fg(
	$isOk ? 'Yes' : 'No',
	$isOk ? 'green' : 'red'
).PHP_EOL;
```

## Changing background color

### Regular method

```php
echo WCC::bgCyan('YoHoHo').PHP_EOL; // YoHoHo will be displayed on cyan background with default foreground color
```

> All availabe backgorund color `@method`s are listed under the class docblock with `bg*` prefix.

### Advanced method

```php
$error = true;
$hasError = $error === true;

echo WCC::bg(
	$hasError ? 'Failed' : 'Ready',
	$hasError ? 'red' : 'black'
).PHP_EOL;
```

## Mixing fore and background colors

```php
echo WCC::bgGreen(WCC::fgYellow('YoHoHo')).PHP_EOL; // YoHoHo will be displayed as yellow text on green background
echo WCC::fgYellow(WCC::bgGreen('YoHoHo')).PHP_EOL; // Produces same output as invocation priority doesn't matter for display
```

## Making text **bold**

```php
echo WCC::bold('YoHoHo').PHP_EOL; // YoHoHo will be displayed bold with default fore/background colors
```

### Making **bold** colors

```php
echo WCC::bold(WCC::fgYellow('YoHoHo')).PHP_EOL; // YoHoHo will be bold yellow
echo WCC::fgYellow(WCC::bold('YoHoHo')).PHP_EOL; // Produces same output
```

```php
echo WCC::bold(WCC::bgCyan('YoHoHo')).PHP_EOL; // YoHoHo will be bold with default color on cyan background
```

```php
echo WCC::bold(WCC::fgYellow(WCC::bgCyan('YoHoHo'))).PHP_EOL; // YoHoHo will be bold yellow on cyan background
```