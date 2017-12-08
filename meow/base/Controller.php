<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 23.10.2017
 * Time: 8:27
 */

namespace meow\base;

use Meow;
use meow\base\Except;
use meow\base\BaseApp;


/**
 * @property View view
 * @property string viewPath
 */
abstract class Controller extends BaseApp
{
    //public $id;
    //public $action;

    /**
     * @var string
     */
    public $basePath = 'index/index';
    /**
     * @var View
     */
    private $view;

    /**
     * @var string
     */
    private $viewPath = '@app/views';

    /**
     * @var string
     */
    public $layout = '@app/views/layouts/index';

    /**
     * @var
     */
    public $viewName;

    /**
     * @var
     */
    public $viewData;

    public function __construct()
    {
        $config = Meow::$app->_config['routing'];
        //TODO если не заданы обработать
        $this->layout = isset($config['layout'])
            ? $config['layout']
            : $this->layout;
        $this->basePath = isset($config['basePath'])
            ? $config['basePath']
            : $this->basePath;
        //$this->viewPath = $config['baseViewsPath'] . DIRECTORY_SEPARATOR . Meow::$app->controllerName;
        $this->viewPath = isset($config['baseViewsPath'])
            ? $config['baseViewsPath']
            : $this->viewPath;
        parent::__construct([]);
    }

    public abstract function actionIndex();

    public final function runAction($action, $params = []){
        //if ($this->beforeAction($action, $params) !== false){
            if (method_exists($this, $action)) {
                $ref = new \ReflectionMethod($this, $action);
                if (!empty($ref->getParameters())) {
                    $_params_ = [];
                    foreach ($ref->getParameters() as $param) {
                        if (array_key_exists($param->name, $params)) {
                            $_params_[$param->name] = $params[$param->name];
                        } else if (!$param->isOptional()) {
                            throw new \Exception("Required parameter $param->name is missed");
                        } else {
                            $_params_[$param->name] = $param->getDefaultValue();
                        }
                    }
                    $content = call_user_func_array([$this, $action],$_params_);
                } else {
                    $content = $this->{$action}();
                }
                if ($content instanceof Response){
                    return $content;
                } else {
                    $response = Meow::$app->response;
                    if ($content !== null){
                        $response->data = $content;
                    }
                    return $response;
                }
            } else {
                //TODO обработать
                //return App::$instance->getResponse()->redirect('/');
                return false;
            }
        //}
        return null;
    }

    public function getView()
    {
        if ($this->view === null) {
            Meow::$app->view = $this->view = new View();
        }
        return $this->view;
    }

    public final function render($view, $params = [])
    {
        $content = $this->getView()->render($this, $view, $params);
        Meow::$app->assetM->registerBundles();
        return $this->renderContent($content);
    }

    public function renderContent($content)
    {
        $layoutFile = $this->findLayoutFile($this->getView());
        if ($layoutFile !== false) {
            return $this->getView()->renderLayout($layoutFile, ['content' => $content]);
        }
        return $content;
    }

    public function findLayoutFile($view)
    {
        if (is_string($this->layout)) {
            $layout = $this->layout;
        }

        if (!isset($layout)) {
            return false;
        }

        if (strncmp($layout, '@', 1) === 0) {
            $file = Meow::getAlias($layout);
        } elseif (strncmp($layout, '/', 1) === 0) {
            $file = Meow::$app->getLayoutPath() . DIRECTORY_SEPARATOR . substr($layout, 1);
        } else {
            $file = Meow::$app->getLayoutPath() . DIRECTORY_SEPARATOR . $layout;
        }

        if (pathinfo($file, PATHINFO_EXTENSION) !== '') {
            return $file;
        }
        $path = $file . '.' . $view->defaultExtension;
        if ($view->defaultExtension !== 'php' && !is_file($path)) {
            $path = $file . '.php';
        }

        return $path;
    }

    public function getViewPath()
    {
        if ($this->viewPath === null) {
            $this->viewPath = Meow::$app->getViewPath() . DIRECTORY_SEPARATOR . Meow::$app->controllerName;
        } else {
            $this->viewPath = Meow::getAlias($this->viewPath). DIRECTORY_SEPARATOR . Meow::$app->controllerName;
        }
        return $this->viewPath;
    }
}