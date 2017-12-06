<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 05.12.2017
 * Time: 20:49
 */

namespace core\base;


use Meow;

class View extends BaseApp
{
    const POS_HEAD   = 1;
    const POS_BEGIN  = 2;
    const POS_END    = 3;
    const HEAD       = '<![CDATA[MEOW-BLOCK-HEAD]]>';
    const BODY_BEGIN = '<![CDATA[MEOW-BLOCK-BODY-BEGIN]]>';
    const BODY_END   = '<![CDATA[MEOW-BLOCK-BODY-END]]>';

    public $title;
    public $metaTags; //TODO тоже в константу?
    public $linkTags;
    public $css;
    public $cssFiles;
    public $js;
    public $jsFiles;

    public $defaultExtension = 'php';

    private $_assetManager;

    public function head()
    {
        echo self::HEAD;
    }

    public function beginBody()
    {
        echo self::BODY_BEGIN;
    }

    public function endBody()
    {
        echo self::BODY_END;

        /*foreach (array_keys($this->assetBundles) as $bundle) {
            $this->registerAssetFiles($bundle);
        }*/
    }

    public function clear()
    {
        $this->metaTags = null;
        $this->linkTags = null;
        $this->css = null;
        $this->cssFiles = null;
        $this->js = null;
        $this->jsFiles = null;
        //$this->assetBundles = [];
    }

    public function render($controller, $view, $params = [])
    {
        $viewFile = $this->findViewFile($controller, $view);
        return $this->renderPhpFile($viewFile, $params);
    }

    public function renderPhpFile($_file_, $_params_ = [])
    {
        ob_start();
        ob_implicit_flush(false);
        extract($_params_, EXTR_OVERWRITE);
        require($_file_);

        return ob_get_clean();
    }

    /**
     * @param $controller Controller
     * @param $view
     * @return bool|mixed|string
     */
    protected function findViewFile($controller = null, $view)
    {
        if (strncmp($view, '@', 1) === 0) {
            // e.g. "@app/views/main"
            $file = Meow::getAlias($view);
        } elseif (strncmp($view, '//', 2) === 0) {
            // e.g. "//layouts/main"
            $file = Meow::$app->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
        } elseif (strncmp($view, '/', 1) === 0) {
            // e.g. "/site/index"
            if (Meow::$app->controller !== null) {
                $file = Meow::$app->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
            } else {
                //TODO обработать
                return "Unable to locate view file for view '$view': no active controller.";
                //throw new InvalidCallException("Unable to locate view file for view '$view': no active controller.");
            }
        } else {
            //TODO обработать
            $file = Meow::$app->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
            return $file;
            //return "Unable to resolve view file for view '$view': no active view context.";
            //throw new InvalidCallException("Unable to resolve view file for view '$view': no active view context.");
        }

        /*elseif ($controller instanceof ViewContextInterface) {
            $file = $controller->getViewPath() . DIRECTORY_SEPARATOR . $view;
        }*/
        /*elseif (($currentViewFile = $this->getViewFile()) !== false) {
            $file = dirname($currentViewFile) . DIRECTORY_SEPARATOR . $view;
        }*/

        if (pathinfo($file, PATHINFO_EXTENSION) !== '') {
            return $file;
        }
        $path = $file . '.' . $this->defaultExtension;
        if ($this->defaultExtension !== 'php' && !is_file($path)) {
            $path = $file . '.php';
        }

        return $path;
    }
}