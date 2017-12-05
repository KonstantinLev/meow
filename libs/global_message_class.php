<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 6:12
 */

require_once 'config/config.php';

abstract class GlobalMessage
{
    private $data;

    public function __construct($file)
    {
        $config = new Config();
        $this->data = parse_ini_file($config->dir_text.$file.'.ini');
    }

    public function get($name)
    {
        return $this->data[$name];
    }
}