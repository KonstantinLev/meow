<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 12/5/17
 * Time: 9:29 AM
 */

namespace core\base;

use Meow;
use core\helpers\Inflector;


class Request extends BaseApp
{
    private $scriptFile;
    private $scriptUrl;
    private $baseUrl;

    private $isPost = false;
    private $isGet = false;
    private $get;
    private $post;

    private $request;

    public function __construct(array $config = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->isPost = true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            $this->isGet = true;
        }
        $this->get = $_GET;
        $this->post = $_POST;
        //$this->files = $_FILES;
        //$this->parseModels();
        $this->request = array_merge($this->get, $this->post/*, $this->files*/);
        parent::__construct($config);
    }

    public function getBaseUrl()
    {
        if ($this->baseUrl === null) {
            $this->baseUrl = rtrim(dirname($this->getScriptUrl()), '\\/');
        }
        return $this->baseUrl;
    }

    public function getScriptUrl()
    {
        if ($this->scriptUrl === null) {
            $scriptFile = $this->getScriptFile();
            $scriptName = basename($scriptFile);
            if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === $scriptName) {
                $this->scriptUrl = $_SERVER['SCRIPT_NAME'];
            } elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) === $scriptName) {
                $this->scriptUrl = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName) {
                $this->scriptUrl = $_SERVER['ORIG_SCRIPT_NAME'];
            } elseif (isset($_SERVER['PHP_SELF']) && ($pos = strpos($_SERVER['PHP_SELF'], '/' . $scriptName)) !== false) {
                $this->scriptUrl = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $scriptName;
            } elseif (!empty($_SERVER['DOCUMENT_ROOT']) && strpos($scriptFile, $_SERVER['DOCUMENT_ROOT']) === 0) {
                $this->scriptUrl = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $scriptFile));
            } else {
                throw new \Exception('Unable to determine the entry script URL.');
            }
        }
        return $this->scriptUrl;
    }

    public function getScriptFile()
    {
        if (isset($this->scriptFile)) {
            return $this->scriptFile;
        } elseif (isset($_SERVER['SCRIPT_FILENAME'])) {
            return $_SERVER['SCRIPT_FILENAME'];
        } else {
            throw new \Exception('Unable to determine the entry script file path.');
        }
    }

    public function getRequest(){
        return $this->request;
    }

    public function request($name){
        if (isset($this->request[$name])){
            return $this->request[$name];
        }
        return null;
    }
}