<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 10.06.2017
 * Time: 15:42
 */

require_once 'config/config.php';
require_once 'CoreUrl.php';
require_once 'format_class.php';
require_once 'template_class.php';
require_once 'message_class.php';

abstract class CoreController
{
    protected $config;
    protected $request;
    protected $url;
    protected $format;
    protected $template;
    protected $message;

    public function __construct()
    {
        session_start();
        $this->config = new Config();
        $this->url = new CoreUrl();
        $this->format = new Format();
        $this->request = $this->format->xss($_REQUEST);
        $this->message = new Message();
    }

    abstract protected function getContent();

    protected function getRequest($name = false)
    {
        if(!$name) return $this->request;
        if(!isset($this->request[$name])) return false;
        return $this->request[$name];
    }

    protected function notFound()
    {
        $this->redirect($this->url->notFound());
    }

    protected function message()
    {
        if (!$_SESSION['message']) return '';
        $text = $this->message->get($_SESSION['message']);
        unset($_SESSION['message']);
        return $text;
    }

    protected function redirect($link)
    {
        header('Location: '.$link);
        exit;
    }

}