<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 08.12.2017
 * Time: 0:52
 */

namespace meow\base;

use Meow;

class AssetBundle extends BaseApp
{
    public $basePath;
    public $baseUrl;
    public $depends = [];
    public $jsFiles = [];
    public $cssFiles = [];

    public static function register()
    {
        //return $view->registerBundle(get_called_class());
        Meow::$app->assetM->registerBundle(get_called_class());
    }
}