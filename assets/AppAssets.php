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
    public $basePath = '@webroot/web';
    public $baseUrl = '@web';

    public $cssFiles = [
        'css/main.css',
    ];
    public $jsFiles = [
        'js/main.js',
    ];
    public $depends = [
        'meow\assets\MeowAsset',
    ];
}