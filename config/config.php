<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 5:21
 */

$config = [
    'db' => require(__DIR__ . '/db.php'),
    'basePath' => dirname(__DIR__),
    'routing' => [
        //'basePath' => 'index/index',
        //'baseViewsPath' => '@app/views',
        //'layout' => '@app/views/layouts/admin',
        'controllersNamespace' => 'app\controllers',
        'baseControllersPath' => '@app/controllers'
    ],
    'siteName' => 'meow-app',
    'adminName' => 'Konstantin',
    'adminEmail' => 'x-stels@bk.ru',
    'assets' => require(__DIR__ . '/assets.php'),
];

return $config;