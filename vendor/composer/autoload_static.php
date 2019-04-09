<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9237d5e9d1f3bfe42d20471102eb0b44
{
    public static $files = array (
        '4ce8053d5de5bb076c50870f996cf5d9' => __DIR__ . '/../..' . '/src/Help.php',
    );

    public static $prefixLengthsPsr4 = array (
        'g' => 
        array (
            'gendiff\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'gendiff\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Docopt' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Argument' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\BranchPattern' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Command' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Either' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\ExitException' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Handler' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\LanguageError' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\LeafPattern' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\OneOrMore' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Option' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Optional' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\OptionsShortcut' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Pattern' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Required' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Response' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
        'Docopt\\Tokens' => __DIR__ . '/..' . '/docopt/docopt/src/docopt.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9237d5e9d1f3bfe42d20471102eb0b44::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9237d5e9d1f3bfe42d20471102eb0b44::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9237d5e9d1f3bfe42d20471102eb0b44::$classMap;

        }, null, ClassLoader::class);
    }
}
