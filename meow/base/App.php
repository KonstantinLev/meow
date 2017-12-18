<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 19.10.2017
 * Time: 20:53
 */

namespace meow\base;

use Meow;

use meow\db\Connection;

/**
 * Class App
 * @property Request request
 * @property Response response
 * @property Connection db
 * @property string basePath
 * @property array config
 * @property AssetManager assetM
 * @property string charset
 * @property Router router
 * @package meow\base
 */
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

    /**
     * @var string
     */
    public $charset = 'UTF-8';

    /**
     * @var View
     */
    public $view;

    /**
     * @var
     */
    public $basePath;

    /**
     * @var
     */
    public $layoutPath;

    /**
     * @var
     */
    public $viewPath;

    /**
     * @var Controller
     */
    public $controller;

    /**
     * @var
     */
    public $controllerName;

    /**
     * @var
     */
    public $actionName;

    /**
     * App constructor.
     * @param array $config
     * @throws \Exception
     */
    public function __construct($config = [])
    {
        //TODO обработать исключение
        Meow::$app = $this;
        $this->preInit($config);
        parent::__construct($config);
    }

    public function run()
    {
        if (isset($this->_config['db'])){
            $this->db = new Connection($this->_config['db']);
            unset($this->_config['db']);
        }

        $this->request = new Request();

        Meow::setAlias('@web', $this->request->baseUrl);
        Meow::setAlias('@webroot', dirname($this->request->scriptFile));
        Meow::setAlias('@meow', MEOW_PATH);

        $this->assetM = new AssetManager(isset($this->_config['assets']) ? $this->_config['assets'] : []);
        $this->router = new Router(isset($this->_config['routing']) ? $this->_config['routing'] : []);
        $this->response = new Response();

        $response = $this->router->route();
        $response->send();
        //TODO возвращаемое значение
        //return $response->exitStatus;
    }

    /**
     * @return Connection
     */
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

    /**
     * @return string
     */
    public function getBasePath()
    {
        //return $this->basePath;
        if ($this->basePath === null) {
            $class = new \ReflectionClass($this);
            $this->basePath = dirname($class->getFileName());
        }

        return $this->basePath;
    }

    /**
     * @param $path
     */
    public function setBasePath($path)
    {
        $this->basePath = $path;
        Meow::setAlias('@app', $this->getBasePath());
    }

    /**
     * @return string
     */
    public function getLayoutPath()
    {
        if ($this->layoutPath === null) {
            $this->layoutPath = $this->getViewPath() . DIRECTORY_SEPARATOR . 'layouts';
        }
        return $this->layoutPath;
    }

    /**
     * @param $path
     */
    public function setLayoutPath($path)
    {
        $this->layoutPath = Meow::getAlias($path);
    }

    /**
     * @return string
     */
    public function getViewPath()
    {
        if ($this->viewPath === null) {
            $this->viewPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'views';
        }
        return $this->viewPath;
    }

    /**
     * @param $path
     */
    public function setViewPath($path)
    {
        $this->viewPath = Meow::getAlias($path);
    }


    /**
     * @param $config
     * @throws \Exception
     */
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