<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite9b5eb8ea6d892f52ec4954899719ac0
{
    public static $files = array (
        'c65d09b6820da036953a371c8c73a9b1' => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook/polyfills.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpssdb\\' => 8,
            'phpFastCache\\' => 13,
        ),
        'P' => 
        array (
            'Psr\\Cache\\' => 10,
            'Predis\\' => 7,
        ),
        'F' => 
        array (
            'Facebook\\' => 9,
        ),
        'A' => 
        array (
            'Abraham\\TwitterOAuth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpssdb\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpfastcache/phpssdb/src/phpssdb',
        ),
        'phpFastCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpfastcache/phpfastcache/src/phpFastCache',
        ),
        'Psr\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/cache/src',
        ),
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
        'Facebook\\' => 
        array (
            0 => __DIR__ . '/..' . '/facebook/graph-sdk/src/Facebook',
        ),
        'Abraham\\TwitterOAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/abraham/twitteroauth/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'Unirest\\' => 
            array (
                0 => __DIR__ . '/..' . '/mashape/unirest-php/src',
            ),
        ),
        'M' => 
        array (
            'Mekit\\' => 
            array (
                0 => __DIR__ . '/../..' . '/src',
            ),
        ),
        'I' => 
        array (
            'InstagramScraper' => 
            array (
                0 => __DIR__ . '/..' . '/raiym/instagram-php-scraper/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite9b5eb8ea6d892f52ec4954899719ac0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite9b5eb8ea6d892f52ec4954899719ac0::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite9b5eb8ea6d892f52ec4954899719ac0::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}