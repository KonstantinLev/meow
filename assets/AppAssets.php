<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 08.12.2017
 * Time: 0:45
 */
namespace app\assets;

use meow\base\AssetBundle;

class AppAssets extends AssetBundle
{
    //TODO на винде и линухе работает по-разному, разобраться '/'
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $cssFiles = [
        'libs/bootstrap/css/bootstrap.min.css',
        'css/main.css',
];
    public $jsFiles = [
        'libs/jquery/jquery-3.2.1.min.js',
        'libs/bootstrap/js/bootstrap.min.js',
        'js/main.js',
    ];
    public $depends = [
        'meow\assets\MeowAsset',
    ];
}