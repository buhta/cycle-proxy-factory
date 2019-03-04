<?php
declare(strict_types=1);

namespace Cycle\ORM\Promise;

class Utils
{
    /**
     * Create short name (without namespaces).
     *
     * @param string $name
     *
     * @return string
     */
    public static function shortName(string $name): string
    {
        $pos = mb_strrpos($name, '\\');
        if ($pos === false) {
            return $name;
        }

        return mb_substr($name, $pos + 1);
    }

    /**
     * Inject values to array at given index.
     *
     * @param array $stmts
     * @param int   $index
     * @param array $child
     *
     * @return array
     */
    public static function injectValues(array $stmts, int $index, array $child): array
    {
        $before = array_slice($stmts, 0, $index);
        $after = array_slice($stmts, $index);

        return array_merge($before, $child, $after);
    }

    /**
     * Remove trailing digits in the given name.
     *
     * @param string $name
     * @param int    $number
     *
     * @return string
     */
    public static function trimTrailingDigits(string $name, int $number): string
    {
        $pos = mb_strripos($name, (string)$number);
        if ($pos === false) {
            return $name;
        }

        return mb_substr($name, 0, $pos);
    }
}