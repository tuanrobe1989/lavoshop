<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteafa8780abaaecd2e28027a67bd6cd92
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'Optinly\\App\\Models\\' => 19,
            'Optinly\\App\\Helpers\\' => 20,
            'Optinly\\App\\Controllers\\Admin\\' => 30,
            'Optinly\\App\\Controllers\\' => 24,
            'Optinly\\App\\' => 12,
            'Optinly\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Optinly\\App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Models',
        ),
        'Optinly\\App\\Helpers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Helpers',
        ),
        'Optinly\\App\\Controllers\\Admin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Controllers/Admin',
        ),
        'Optinly\\App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Controllers',
        ),
        'Optinly\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
        'Optinly\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteafa8780abaaecd2e28027a67bd6cd92::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteafa8780abaaecd2e28027a67bd6cd92::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
