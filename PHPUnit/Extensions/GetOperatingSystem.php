<?php

/**
 * The class detects the operating system, machine type and
 * bit size used by the current runtime environment of PHP.
 */
class GetOperatingSystem
{
    /**
     * Returns the Operating System and Release Version.
     *
     * @return string
     */
    public static function getOS()
    {
        return str_replace(' ' , '_', php_uname('s') . ' ' . php_uname('r'));
    }

    public static function getWindowsVersion()
    {
        $r = php_uname('r');

        $os = array(
            '5.1' => 'XP',
            '5.2' => 'XP Pro x64',
            '6.0' => 'Vista',
            '6.1' => '7',
            '6.2' => '8',
        );

        return (isset($os[$r]) === true) ? $os[$r] : $r;
    }

    /**
     * Returns the machine type, eg. i686.
     *
     * @return string machine type. eg. i386.
     */
    public static function getMachine()
    {
        return php_uname('m');
    }

    /**
     * Returns the Bit-Size.
     *
     * @return string BitSize, e.g. 32, 64.
     */
    public static function getBitSize()
    {
        if (PHP_INT_SIZE === 4) {
            return '32';
        }

        // @codeCoverageIgnoreStart
        if (PHP_INT_SIZE === 8) {
            return '64';
        }

        return PHP_INT_SIZE; // 16-bit?
        // @codeCoverageIgnoreEnd
    }

    public function __toString()
    {
        return sprintf('OS %s %s (%s-bit)', self::getOS(), self::getMachine(), self::getBitSize());
    }
}
