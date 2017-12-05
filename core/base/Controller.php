<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 23.10.2017
 * Time: 8:27
 */

namespace core\base;

use Meow;
use core\base\Except;


abstract class Controller extends BaseApp
{
    public $layout = 'main';
    public $viewName;
    public $viewData;

    public $basePath;
    public $viewsPath;

    function __call($methodName, $args=array()){
        if (method_exists($this, $methodName))
            return call_user_func_array(array($this,$methodName),$args);
        else
            throw new Except('In controller '.get_called_class().' method '.$methodName.' not found!');
    }

    public function __construct()
    {
        $config = Meow::$app->_config;
        //TODO если не заданы обработать
        $this->layout = $config['routing']['layout'];
        $this->basePath = $config['routing']['basePath'];
        $this->viewsPath = $config['routing']['baseViewsPath'];
        parent::__construct($config);
    }

    public final function runAction($action, $params = []){
        //if ($this->beforeAction($action, $params) !== false){
        $a = 13;
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

    public abstract function actionIndex();

    //TODO доделать
    public function addScript($link, $where = 'head'){
        Meow::$app->assetM->addAsset($link, $where);
    }
    public function addStyleSheet($link, $where = 'head'){
        Meow::$app->assetM->addAsset($link, $where, 'style');
    }
    public function addScriptDeclaration($data, $where = 'head'){
        Meow::$app->assetM->addAsset($data, $where, 'script', 'inline');
    }
    public function addStyleSheetDeclaration($data, $where = 'head'){
        Meow::$app->assetM->addAsset($data, $where, 'style', 'inline');
    }

}