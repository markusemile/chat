<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit8cfa1d90f6d8d5c5e604c98aa6b7550d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit8cfa1d90f6d8d5c5e604c98aa6b7550d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit8cfa1d90f6d8d5c5e604c98aa6b7550d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit8cfa1d90f6d8d5c5e604c98aa6b7550d::getInitializer($loader));

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInit8cfa1d90f6d8d5c5e604c98aa6b7550d::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire8cfa1d90f6d8d5c5e604c98aa6b7550d($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequire8cfa1d90f6d8d5c5e604c98aa6b7550d($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}