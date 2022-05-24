<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8cfa1d90f6d8d5c5e604c98aa6b7550d
{
    public static $files = array (
        'ebf8799635f67b5d7248946fe2154f4a' => __DIR__ . '/..' . '/ringcentral/psr7/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RingCentral\\Psr7\\' => 17,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'F' => 
        array (
            'Fig\\Http\\Message\\' => 17,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RingCentral\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/ringcentral/psr7/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Fig\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/fig/http-message-util/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $prefixesPsr0 = array (
        'E' => 
        array (
            'Evenement' => 
            array (
                0 => __DIR__ . '/..' . '/evenement/evenement/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8cfa1d90f6d8d5c5e604c98aa6b7550d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8cfa1d90f6d8d5c5e604c98aa6b7550d::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit8cfa1d90f6d8d5c5e604c98aa6b7550d::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit8cfa1d90f6d8d5c5e604c98aa6b7550d::$classMap;

        }, null, ClassLoader::class);
    }
}