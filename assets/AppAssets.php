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
        'css/script.css',
        'css/work.css',
    ];
    public $jsFiles = [
        'js/main.js',
        'js/work.js',
    ];
    public $depends = [
        'meow\assets\MeowAsset',
    ];
}