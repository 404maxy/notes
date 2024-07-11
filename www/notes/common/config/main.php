<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
//       TODO: предоставить настройки для подключения к базе в main-local.php в сопроводительном письме
//        'db' => [
//            'class' => \yii\db\Connection::class,
//            'dsn' => 'mysql:host=notes_mysql;dbname=notes',
//            'username' => 'notes',
//            'password' => 'n0t3sPwd',
//            'charset' => 'utf8',
//        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];
