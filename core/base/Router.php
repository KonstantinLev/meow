<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 05.12.2017
 * Time: 7:40
 */

namespace core\base;

use Meow;
use core\helpers\Inflector;

class Router extends BaseApp
{
    private $defaultController = 'Index';

    private $defaultAction = 'Index';

    private $controller;

    private $action;

    private $route;

    private $controllersPath;

    private $controllersNamespace = 'app\\controllers';

    public function __construct(array $config = [])
    {
        $defaults = isset($config['basePath'])
            ? explode('/', $config['basePath'])
            : ['Index', 'Index'];
        $this->defaultController = isset($defaults[0]) ? $defaults[0] : $this->defaultController;
        $this->defaultAction = isset($defaults[1]) ? $defaults[1] : $this->defaultAction;
        $this->controllersNamespace = isset($config['controllersNamespace'])
            ? $config['controllersNamespace']
            : $this->controllersNamespace ;
        $this->controllersPath = isset($config['baseControllersPath'])
            ? $config['baseControllersPath']
            : '@app/controllers';
        parent::__construct($config);
    }

    public function route()
    {
        $this->parseRequest();
        $this->parseRoute();
        return $this->defaultResolve();
    }

    public function parseRequest()
    {
        $request = $_SERVER['REQUEST_URI'];
        $requestParts = explode('?', $request);
        $this->route = str_replace(Meow::$app->request->getBaseUrl().'/', '',$requestParts[0]);
        $this->parseRoute();
    }

    public function parseRoute()
    {
        $pathParts = explode('/', $this->route);
        $this->controller = Inflector::id2camel((!empty($pathParts[0]) ? $pathParts[0] : $this->defaultController));
        $this->action = Inflector::id2camel((!empty($pathParts[1]) ? $pathParts[1] : $this->defaultAction));
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function defaultResolve(){
        Meow::$app->controllerName = strtolower($this->controller);
        Meow::$app->actionName = strtolower($this->action);
        $controller = $this->controller.'Controller';
        $action = 'action'.$this->action;
        $controllerPath = Meow::getAlias($this->controllersPath).DIRECTORY_SEPARATOR.$controller.'.php';
        if (file_exists($controllerPath)) {
            $className = $this->controllersNamespace.'\\' . $controller;
            /**
             * @var Controller $controllerClass
             */
            Meow::$app->controller = $controllerClass = new $className();
            return $controllerClass->runAction($action, Meow::$app->request->request);
        } else {
            return false;
            //TODO обработать
            //return Meow::$app->getResponse()->redirect('/');
        }
    }

}