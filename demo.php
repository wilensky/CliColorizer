<?php
declare(strict_types = 1);

require('CliColorizer.php');

use Wilensky\CliColorizer as WCC;

// Discovering the magic //

$r = new \ReflectionClass(WCC::class);

$docComm = $r->getDocComment();
$annotations = [];

preg_match_all('/@method\s(.*?)\n/s', $docComm, $annotations);

/** @var array $method */
$methods = array_map(function (string $ann): string {
    $m = [];
    preg_match('/\s(\w+)\(/', $ann, $m);
    
    return $m[1];
}, $annotations[1]);

unset($r, $docComm, $annotations);

// Starting demo //

echo WCC::fgLGreen(WCC::bold('=== Typeface demo ===')).PHP_EOL;

echo implode(PHP_EOL, [
    WCC::bold('bold()').' - method makes text '.WCC::bold('bold'),
    WCC::underline('underline()').' - '.WCC::underline('underlines').' it',
    WCC::invert('invert()').' - '.WCC::invert('inverts'),
    'hide() - my password >'.WCC::hide((string)time()).'< is '.strlen((string)time()).' chars long'
]).PHP_EOL;

echo PHP_EOL;

echo WCC::fgYellow(WCC::bold('=== Colors demo ===')).PHP_EOL;

echo implode(' ', array_map(function (string $method): string {
    return call_user_func(WCC::class.'::'.$method, $method.'()');
}, $methods)).PHP_EOL;