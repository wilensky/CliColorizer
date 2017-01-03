<?php
declare(strict_types = 1);

namespace Wilensky;

/**
 * CLI colorizer
 * Whole class is static for ease of use and integration
 * @method string fgBlack(string $string, bool $rst = true)
 * @method string fgLGray(string $string, bool $rst = true)
 * @method string fgDGray(string $string, bool $rst = true)
 * @method string fgBlue(string $string, bool $rst = true)
 * @method string fgLBlue(string $string, bool $rst = true)
 * @method string fgGreen(string $string, bool $rst = true)
 * @method string fgLGreen(string $string, bool $rst = true)
 * @method string fgCyan(string $string, bool $rst = true)
 * @method string fgLCyan(string $string, bool $rst = true)
 * @method string fgRed(string $string, bool $rst = true)
 * @method string fgLRed(string $string, bool $rst = true)
 * @method string fgMagenta(string $string, bool $rst = true)
 * @method string fgLMagenta(string $string, bool $rst = true)
 * @method string fgBrown(string $string, bool $rst = true)
 * @method string fgYellow(string $string, bool $rst = true)
 * @method string fgWhite(string $string, bool $rst = true)
 * @method string bgBlack(string $string, bool $rst = true)
 * @method string bgDGray(string $string, bool $rst = true)
 * @method string bgRed(string $string, bool $rst = true)
 * @method string bgGreen(string $string, bool $rst = true)
 * @method string bgYellow(string $string, bool $rst = true)
 * @method string bgBlue(string $string, bool $rst = true)
 * @method string bgMagenta(string $string, bool $rst = true)
 * @method string bgCyan(string $string, bool $rst = true)
 * @method string bgLGray(string $string, bool $rst = true)
 * @author Gregg Wilensky <https://github.com/wilensky/>
 */
class CliColorizer
{
    /** Bold sequence */
    const BOLD = "\e[1m";
    /** Underline sequence */
    const UNDERLINE = "\e[4m";
    /** Invert sequence */
    const INVERT = "\e[7m";
    /** Hide sequence */
    const HIDE = "\e[8m";

    /** Reset all attributes */
    const RESET_ALL = "\e[0m";
    
    /** Particular attributes reset sequences */
    const RESET = [
        'ALL' => self::RESET_ALL,
        self::BOLD => "\e[21m",
        self::UNDERLINE => "\e[24m",
        self::INVERT => "\e[27m",
        self::HIDE => "\e[28m"
    ];
    
    /** Foreground colors */
    const FG = [
        'BLACK' => "\033[0;30m",
        'L_GRAY' => "\033[0;37m",
        'D_GRAY' => "\033[1;30m",
        'BLUE' => "\033[0;34m",
        'L_BLUE' => "\033[1;34m",
        'GREEN' => "\033[0;32m",
        'L_GREEN' => "\033[1;32m",
        'CYAN' => "\033[0;36m",
        'L_CYAN' => "\033[1;36m",
        'RED' => "\033[0;31m",
        'L_RED' => "\033[1;31m",
        'MAGENTA' => "\033[0;35m",
        'L_MAGENTA' => "\033[1;35m",
        'BROWN' => "\033[0;33m",
        'YELLOW' => "\033[1;33m",
        'WHITE' => "\033[1;37m"
    ];

    /** Background colors */
    const BG = [
        'BLACK' => "\033[0m",
        'D_GRAY' => "\033[40m",
        'RED' => "\033[41m",
        'GREEN' => "\033[42m",
        'YELLOW' => "\033[43m",
        'BLUE' => "\033[44m",
        'MAGENTA' => "\033[45m",
        'CYAN' => "\033[46m",
        'L_GRAY' => "\033[47m"
    ];

    /**
     * Generic string decorator 
     * @param string $escape
     * @param string $str
     * @param bool $rst
     * @return string
     */
    private static function str(string $escape, string $str, bool $rst = true): string
    {
        return sprintf(
            '%s%s%s',
            $escape,
            $str,
            $rst === true ? self::RESET_ALL : ''
        );
    }
    
    /**
     * Foreground colorizer
     * @param string $s
     * @param string $color
     * @param bool $rst
     * @return string
     */
    public static function fg(string $s, string $color = 'l_gray', bool $rst = true): string
    {
        $clr = strtoupper($color);
        
        if ((self::FG[$clr] ?? null) === null) {
            throw new \RuntimeException('Unknown foreground color `' . $color . '`', 100);
        }
        return self::str(self::FG[$clr], $s, $rst);
    }

    /**
     * Background colorizer
     * @param string $s
     * @param string $color
     * @param bool $rst
     * @return string
     */
    public static function bg(string $s, string $color = 'black', bool $rst = true): string
    {
        $clr = strtoupper($color);
        
        if ((self::BG[$clr] ?? null) === null) {
            throw new \RuntimeException('Unknown background color `' . $color . '`', 200);
        }
        return self::str(self::BG[$clr], $s, $rst);
    }

    /**
     * Generic format decorator
     * @param string $tf Typeface escape sequence
     * @param string $str Output string
     * @param bool $rst Flag for resetting typeface by the end of the string
     * @return string
     */
    private static function strFormat(string $tf, string $str, bool $rst = true): string
    {
        return self::str($tf, $str, false).($rst === true ? (self::RESET[$tf] ?? '') : '');
    }
    
    /**
     * Bold text
     * @param string $s
     * @param bool $rst
     * @return string
     */
    public static function bold(string $s, bool $rst = true): string
    {
        return self::strFormat(self::BOLD, $s, $rst);
    }
    
    /**
     * Underlined text
     * @param string $s
     * @param bool $rst
     * @return string
     */
    public static function underline(string $s, bool $rst = true): string
    {
        return self::strFormat(self::UNDERLINE, $s, $rst);
    }
    
    /**
     * Inverted text
     * @param string $s
     * @param bool $rst
     * @return string
     */
    public static function invert(string $s, bool $rst = true): string
    {
        return self::strFormat(self::INVERT, $s, $rst);
    }
    
    /**
     * Hidden text
     * @param string $s
     * @param bool $rst
     * @return string
     */
    public static function hide(string $s, bool $rst = true): string
    {
        return self::strFormat(self::HIDE, $s, $rst);
    }
    
    /**
     * Provides convenient magic for the class
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public static function __callStatic($name, $arguments)
    {
        $color = ltrim(strtoupper(preg_replace('/[A-Z]/', '_$0', $name)), '_');
        
        if (strpos($color, 'FG_') === 0) {
            array_splice($arguments, 1, 0, substr($color, 3)); // Avoiding `FG_` prefix
            return self::fg(...$arguments);
        }
        
        if (strpos($color, 'BG_') === 0) {
            array_splice($arguments, 1, 0, substr($color, 3)); // Avoiding `BG_` prefix
            return self::bg(...$arguments);
        }
        
        throw new \BadFunctionCallException('Wrong method '.$name.'()');
    }
}
