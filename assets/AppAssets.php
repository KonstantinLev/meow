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
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $cssFiles = [
        'css/main.css',
        'libs/bootstrap/css/bootstrap.min.css',
    ];
    public $jsFiles = [
        'js/main.js',
        'libs/bootstrap/js/bootstrap.min.js',
    ];
    public $depends = [
        'meow\assets\MeowAsset',
    ];
}