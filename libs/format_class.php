<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 5:45
 */

require_once 'config/config.php';

class Format
{
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function ts()
    {
        return time();
    }

    public function xss($data)
    {
        if (is_array($data)) {
            $escaped = array();
            foreach($data as $key => $val){
                $escaped[$key] = $this->xss($val);
            }
            return $escaped;
        }
        return htmlspecialchars($data);
    }
}