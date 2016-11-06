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
 * @method string fgPurple(string $string, bool $rst = true)
 * @method string fgLPurple(string $string, bool $rst = true)
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
    /** Reset escape */
    const RST = "\e[0m";

    /** Bold escape */
    const BOLD = "\e[1m";

    /** Foreground constants prefix */
    const FG_PREFIX = 'FG_';
    
    /** Background constants prefix */
    const BG_PREFIX = 'BG_';

    /** Foreground color escape */
    const FG_BLACK = "\033[0;30m";
    const FG_L_GRAY = "\033[0;37m";
    const FG_D_GRAY = "\033[1;30m";
    const FG_BLUE = "\033[0;34m";
    const FG_L_BLUE = "\033[1;34m";
    const FG_GREEN = "\033[0;32m";
    const FG_L_GREEN = "\033[1;32m";
    const FG_CYAN = "\033[0;36m";
    const FG_L_CYAN = "\033[1;36m";
    const FG_RED = "\033[0;31m";
    const FG_L_RED = "\033[1;31m";
    const FG_PURPLE = "\033[0;35m";
    const FG_L_PURPLE = "\033[1;35m";
    const FG_BROWN = "\033[0;33m";
    const FG_YELLOW = "\033[1;33m";
    const FG_WHITE = "\033[1;37m";

    /** Background color escape */
    const BG_BLACK = "\033[0m";
    const BG_D_GRAY = "\033[40m";
    const BG_RED = "\033[41m";
    const BG_GREEN = "\033[42m";
    const BG_YELLOW = "\033[43m";
    const BG_BLUE = "\033[44m";
    const BG_MAGENTA = "\033[45m";
    const BG_CYAN = "\033[46m";
    const BG_L_GRAY = "\033[47m";

    /**
     * @param string $constant
     * @return string
     * @throws \RuntimeException
     */
    private static function getColor(string $constant): string
    {
        $fqcn = __CLASS__ . '::' . $constant;
        if (!defined($fqcn)) {
            throw new \RuntimeException('Unknown color `' . $constant . '`');
        }

        return constant($fqcn);
    }

    /**
     * @param string $color
     * @param string $s
     * @param bool $rst
     * @return string
     */
    private static function str(string $color, string $s, bool $rst = true): string
    {
        return sprintf(
            '%s%s%s'.self::RST,
            self::getColor(strtoupper($color)),
            $s,
            $rst === true ? self::RST : ''
        );
    }
    
    /**
     * @param string $s
     * @param string $color
     * @param bool $rst
     * @return string
     */
    public static function fg(string $s, string $color = 'l_gray', bool $rst = true): string
    {
        return self::str(self::FG_PREFIX.$color, $s, $rst);
    }

    /**
     * @param string $s
     * @param string $color
     * @param bool $rst
     * @return string
     */
    public static function bg(string $s, string $color = 'black', bool $rst = true): string
    {
        return self::str(self::BG_PREFIX.$color, $s, $rst);
    }

    /**
     * @param string $s
     * @param bool $rst
     * @return string
     */
    public static function bold(string $s, bool $rst = true): string
    {
        return self::str('bold', $s, $rst);
    }
    
    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public static function __callStatic($name, $arguments)
    {
        $color = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $name)), '_');
        
        array_unshift($arguments, $color);
        
        return forward_static_call_array([self::class, 'str'], $arguments);
    }
}
