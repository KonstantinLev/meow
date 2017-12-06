<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 19.10.2017
 * Time: 21:24
 */

namespace meow\base;

use meow\helpers\ArrayHelper;


abstract class Configurable
{
    protected $_config = [];

    public function __construct($config = [])
    {
        if (!empty($config)){
            $this->_config = ArrayHelper::merge($this->_config, $config);
        }
    }

    public function getConfig(){
        return $this->_config;
    }
}