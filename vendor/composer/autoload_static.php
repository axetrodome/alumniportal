<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitda3e13d7443229e0866b3d2b248e7a65
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Faker\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitda3e13d7443229e0866b3d2b248e7a65::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitda3e13d7443229e0866b3d2b248e7a65::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}