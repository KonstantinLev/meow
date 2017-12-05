<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 6:06
 */

require_once 'config/config.php';

class Check
{

    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function id($id, $zero = false)
    {
        if(!$this->intNumber($id)) return false;
        if((!$zero) && ($id === 0)) return false;
        return $id >= 0;
    }

    public function ids($ids)
    {
        $reg = "/^\d+(,\d+)*\d?$/i";
        return preg_match($reg, $ids);
    }

    public function amount($amount)
    {
        if (!$this->doubleNumber($amount)) return false;
        return $amount >= 0;
    }

    private function doubleNumber($number)
    {
        return is_numeric($number);
    }

    public function name($name)
    {
        if ($this->isContainQuotes($name)) return false;
        return $this->isString($name, 1, $this->config->max_name);
    }

    public function title($title)
    {
        return $this->isString($title, 1, $this->config->max_title);
    }

    public function email($email)
    {
        if ($this->isContainQuotes($email)) return false;
        $reg = "/[a-z0-9_-]+(\.[a-z0-9_-]+)*@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})/i";
        return preg_match($reg, $email);
    }

    public function text($text, $empty = false)
    {
        if (($empty) && ($text == '')) return true;
        return $this->isString($text, 1, $this->config->max_text);
    }

    public function ts($ts)
    {
        return $this->noNegativeInteger($ts);
    }

    private function isContainQuotes($string)
    {
        $arr = array("\"", "'", "`", "&quot;", "&apos;");
        foreach($arr as $key => $val){
            if (strpos($string, $val) !== false) return true;
        }
        return false;
    }

    private function isString($string, $minLength, $maxLength)
    {
        if (!is_string($string)) return false;
        if (strlen($string) < $minLength) return false;
        if (strlen($string) > $maxLength) return false;
        return true;
    }


    public function oneOrZero($number)
    {
        if(!$this->intNumber($number)) return false;
        return (($number == 0) || ($number == 1));
    }

    private function intNumber($number)
    {
        if (!is_int($number) && (!is_string($number))) return false;
        return preg_match("/^-?(([1-9][0-9]*)|(0))$/", $number);
    }

    public function count($count)
    {
        return $this->noNegativeInteger($count);
    }

    public function offset($offset)
    {
        return $this->intNumber($offset);
    }

    private function noNegativeInteger($number)
    {
        if (!$this->intNumber($number)) return false;
        return ($number >= 0);

    }


}