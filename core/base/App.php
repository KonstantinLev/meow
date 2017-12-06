<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 19.10.2017
 * Time: 20:53
 */

namespace core\base;

use Meow;

use core\db\Connection;

class App extends BaseApp
{
    /**
     * @var Connection
     */
    public $db;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var Router
     */
    public $router;
    /**
     * @var AssetManager
     */
    public $assetM;

    public $charset = 'UTF-8';

    /**
     * @var View
     */
    public $view;

    public $basePath;
    public $layoutPath;
    public $viewPath;

    /**
     * @var Controller
     */
    public $controller;
    public $controllerName;
    public $actionName;

    public function __construct($config = [])
    {
        //TODO обработать исключение
        Meow::$app = $this;
        $this->preInit($config);
        parent::__construct($config);
    }

    public function run()
    {
//        static::$instance = $this;
        $this->response = new Response();
//        $response = $this->_router->route();
//        $response->send();
//        return $response->exitStatus;
        $this->request = new Request();
        //TODO обработать метод
        $this->db = new Connection(isset($this->_config['db']) ? $this->_config['db'] : []);
        //if (isset($this->_config['db'])){
        //unset($this->_config['db']);
        //}
        $this->assetM = new AssetManager(isset($this->_config['assets']) ? $this->_config['assets'] : []);
        $this->router = new Router(isset($this->_config['routing']) ? $this->_config['routing'] : []);
        $this->router->route();
//        $this->request = new Request();
//        Meow::setAlias('@web', $this->request->baseUrl);
//        Meow::setAlias('@webroot', dirname($this->request->scriptFile));
//        Meow::setAlias('@meow', MEOW_PATH);
    }

    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return Response
     */
    public function getResponse(){
        return $this->response;
    }

    public function getBasePath()
    {
        //return $this->basePath;
        if ($this->basePath === null) {
            $class = new \ReflectionClass($this);
            $this->basePath = dirname($class->getFileName());
        }

        return $this->basePath;
    }

    public function setBasePath($path)
    {
        $this->basePath = $path;
        Meow::setAlias('@app', $this->getBasePath());
    }

    public function getLayoutPath()
    {
        if ($this->layoutPath === null) {
            $this->layoutPath = $this->getViewPath() . DIRECTORY_SEPARATOR . 'layouts';
        }
        return $this->layoutPath;
    }

    public function setLayoutPath($path)
    {
        $this->layoutPath = Meow::getAlias($path);
    }

    public function getViewPath()
    {
        if ($this->viewPath === null) {
            $this->viewPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'views';
        }
        return $this->viewPath;
    }

    public function setViewPath($path)
    {
        $this->viewPath = Meow::getAlias($path);
    }



    private function preInit($config)
    {
        if (isset($config['basePath'])) {
            $this->setBasePath($config['basePath']);
        } else {
            throw new \Exception('Missed required basePath in configuration');
        }
        if (!isset($config['routing']['layout'])) {
            $this->_config['routing']['layout'] = '@app/views/layouts/index';
        }
    }
}