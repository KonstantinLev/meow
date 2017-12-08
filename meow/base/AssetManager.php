<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 10/20/17
 * Time: 5:16 PM
 */

namespace meow\base;

use Meow;
use meow\helpers\FileHelper;

class AssetManager extends BaseApp
{
    public $dirMode = 0775;
    public $fileMode = 0777;
    /**
     * @var array
     */
    public $bundles = [];

    /**
     * @var array
     */
    public $registeredBundles = [];
    /**
     * @var string
     */
    public $basePath = '@webroot/assets';
    /**
     * @var string
     */
    public $baseUrl = '@web/assets';

    function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->basePath = Meow::getAlias($this->basePath);
        if (!is_dir($this->basePath)) {
            throw new \Exception("The directory does not exist: {$this->basePath}");
        } elseif (!is_writable($this->basePath)) {
            throw new \Exception("The directory is not writable by the Web process: {$this->basePath}");
        } else {
            $this->basePath = realpath($this->basePath);
        }
        //$this->baseUrl = rtrim(Meow::getAlias($this->baseUrl), '/');
        $this->baseUrl = FileHelper::normalizePath(Meow::getAlias('@web') . '\\assets\\');



        foreach ($config['bundles'] as $bundle) {
            if (is_subclass_of($bundle, AssetBundle::className())) {
                $this->bundles[] = $bundle;
            }
        }
    }

    public function registerBundles()
    {
        if (!empty($this->bundles) /*&& Meow::$app->view != null*/) {
            foreach ($this->bundles as $bundle) {
                $bundle::register();
            }
        }
    }

    public function registerBundle($className)
    {
        /**
         * @var AssetBundle $bundle
         */
        $bundle = new $className();
        $view = Meow::$app->view;
        if ($view == null || !$bundle instanceof AssetBundle || in_array($bundle::className(), $this->registeredBundles)) {
            return;
        }
        $css = $bundle->cssFiles;
        $js = $bundle->jsFiles;
        $depends = $bundle->depends;
        if (!empty($depends)) {
            foreach ($depends as $subBundle) {
                if (is_subclass_of($subBundle, AssetBundle::className())) {
                    /**
                     * @var AssetBundle $subBundle
                     */
                    $subBundle::register();
                }
            }
        }
        if (!empty($css)) {
            foreach ($css as $path) {
                $path = $bundle->basePath . DIRECTORY_SEPARATOR . $path;
                if (($url = $this->publishFile($path)) !== false) {
                    $view->registerCssFile($url, View::POS_HEAD);
                }
            }
        }
        if (!empty($js)) {
            foreach ($js as $path) {
                $path = $bundle->basePath . DIRECTORY_SEPARATOR . $path;
                if (($url = $this->publishFile($path)) !== false) {
                    $view->registerJsFile($url, View::POS_END);
                }
            }
        }
        $this->registeredBundles[] = $bundle::className();
    }

    public function publishFile($path)
    {
        $path = FileHelper::normalizePath(Meow::getAlias($path));
        if (is_file($path)) {
            $assetPath = $this->basePath . DIRECTORY_SEPARATOR . basename($path);
            if (is_file($assetPath)) {
                if (md5_file($assetPath) !== md5_file($path)) {
                    copy($path, $assetPath);
                    @chmod($assetPath, $this->fileMode);
                }
            } else {
                if (FileHelper::createDirectory(dirname($assetPath), $this->dirMode)) {
                    copy($path, $assetPath);
                    @chmod($assetPath, $this->fileMode);
                }
            }
            //return 'assets/' . basename($assetPath);
            return $this->baseUrl . DIRECTORY_SEPARATOR . basename($path);
        }
        return false;
    }
}