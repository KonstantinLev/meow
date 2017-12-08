<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 08.12.2017
 * Time: 1:08
 */

namespace meow\assets;

use meow\base\AssetBundle;

class MeowAsset extends AssetBundle
{
    //public $sourcePath = '@meow/assets';
    public $basePath = '@meow/assets';
    public $jsFiles = [
        'meow.js',
    ];
    public $cssFiles = [
        'meow.css',
    ];
}
