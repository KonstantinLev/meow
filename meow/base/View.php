<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 05.12.2017
 * Time: 20:49
 */

namespace meow\base;


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

    public $_content;

    public $defaultExtension = 'php';

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

    public function renderLayout($_file_, $_params_ = [])
    {
        //TODO для загрузки лайаута + css/js и тп
        if (file_exists($_file_)){
            //$this->_params = $_params_;
            $_obInitialLevel_ = ob_get_level();
            ob_start();
            ob_implicit_flush(false);
            extract($_params_, EXTR_OVERWRITE);
            try {
                require $_file_;
                $this->_content = ob_get_clean();
                $this->prepareLayout();
                return $this->_content;
            }
            catch (\Exception $ex){
                while (ob_get_level() > $_obInitialLevel_) {
                    if (!@ob_end_clean()) {
                        ob_clean();
                    }
                }
                throw $ex;
            }
        }
        return null;
    }

    private function prepareLayout()
    {
        $result = $this->prepareContent($this->cssFiles);
        $result = $this->prepareContent($this->jsFiles, $result);
        $this->_content = strtr($this->_content, [
            //View::META => $preparedMeta,
            View::HEAD => $result['head'],
            View::BODY_BEGIN => $result['bodyBegin'],
            View::BODY_END => $result['bodyEnd']
        ]);

    }

    private function prepareContent($files, $resultOut = false)
    {
        $resultOut = is_array($resultOut) ? $resultOut : [];
        foreach($files as $file){
            foreach($file as $pos => $val){
                switch ($pos){
                    case View::POS_HEAD:
                        $resultOut['head'] .= $val;
                        break;
                    case View::POS_BEGIN:
                        $resultOut['bodyBegin'] .= $val;
                        break;
                    case View::POS_END:
                        $resultOut['bodyEnd'] .= $val;
                        break;
                }
            }
        }
        return $resultOut;
    }

    /**
     * @param $controller Controller
     * @param $view
     * @return bool|mixed|string
     */
    protected function findViewFile($controller = null, $view)
    {
//        if (strncmp($view, '@', 1) === 0) {
//            // e.g. "@app/views/main"
//            $file = Yii::getAlias($view);
//        } elseif (strncmp($view, '//', 2) === 0) {
//            // e.g. "//layouts/main"
//            $file = Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
//        } elseif (strncmp($view, '/', 1) === 0) {
//            // e.g. "/site/index"
//            if (Yii::$app->controller !== null) {
//                $file = Yii::$app->controller->module->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
//            } else {
//                throw new InvalidCallException("Unable to locate view file for view '$view': no active controller.");
//            }
//        } elseif ($context instanceof ViewContextInterface) {
//            $file = $context->getViewPath() . DIRECTORY_SEPARATOR . $view;
//        } elseif (($currentViewFile = $this->getViewFile()) !== false) {
//            $file = dirname($currentViewFile) . DIRECTORY_SEPARATOR . $view;
//        } else {
//            throw new \Exception("Unable to resolve view file for view '$view': no active view context.");
//        }
        $file = $controller->getViewPath() . DIRECTORY_SEPARATOR . $view;
        if (pathinfo($file, PATHINFO_EXTENSION) !== '') {
            return $file;
        }
        $path = $file . '.' . $this->defaultExtension;
        if ($this->defaultExtension !== 'php' && !is_file($path)) {
            $path = $file . '.php';
        }

        return $path;
    }

    public function registerCssFile($url, $pos = View::POS_HEAD, $options = []){
        //$path = Meow::$app->request->getBaseUrl().'/'.$url;
        $url = Meow::getAlias($url);
        //$content = Html::tag('link', '', array_merge($options, ['rel' => 'stylesheet', 'href' => $path]));
        $content = '<link href="'.$url.'" rel="stylesheet">';
        $this->cssFiles[][$pos] = $content;
    }

    public function registerJsFile($url, $pos = View::POS_END, $options = [])
    {
        $url = Meow::getAlias($url);
        //$content = '<script type="text/javascript"></script>';
        $content = '<script src="'.$url.'"></script>';
        $this->jsFiles[][$pos] = $content;
    }
}