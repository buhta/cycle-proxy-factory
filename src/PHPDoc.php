<?php
declare(strict_types=1);

namespace Spiral\Cycle\Promise;

use PhpParser\Comment\Doc;

class PHPDoc
{
    public static function writeInheritdoc(): Doc
    {
        $lines = [
            "/**",
            " * {@inheritdoc}",
            " */"
        ];

        return self::makeComment(join("\n", $lines));
    }

    public static function writeProperty(string $type): Doc
    {
        return self::makeComment("/** @var $type */");
    }

    private static function makeComment(string $comment): Doc
    {
        return new Doc($comment);
    }
}