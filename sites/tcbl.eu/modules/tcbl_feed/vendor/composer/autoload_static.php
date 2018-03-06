<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6179928242d243d6758298367446bac6
{
    public static $files = array (
        'c65d09b6820da036953a371c8c73a9b1' => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook/polyfills.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Facebook\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Mekit\\' => 
            array (
                0 => __DIR__ . '/../..' . '/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6179928242d243d6758298367446bac6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6179928242d243d6758298367446bac6::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit6179928242d243d6758298367446bac6::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}