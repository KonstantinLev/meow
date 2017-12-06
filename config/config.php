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
        'basePath' => 'index/index',
        'baseViewsPath' => '@app/views/admin',
        'layout' => '@app/views/layouts/index',
        'controllersNamespace' => 'app\controllers',
        'baseControllersPath' => '@app/controllers'
    ],
    'siteName' => 'php-site-core',
    'adminName' => 'Konstantin',
    'adminEmail' => 'x-stels@bk.ru',
    'dir' => [
      'text' => 'libs/text/',
      'views' => 'views/',
      'img' => 'files/img/',
      'bower_asset' => 'vendor/bower-asset/',
    ],
    'assets' => require(__DIR__ . '/assets.php'),
];

return $config;