<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 15.06.2017
 * Time: 22:55
 */

class SystemMessage
{
    public function __construct()
    {
        session_start();
    }

    public function message($name, $result = false)
    {
        if($name == 'UNKNOWN_ERROR') return $this->unknownError();
        $_SESSION['message'] = $name;
        return $result;
    }

    public function pageMessage($name, $result = true)
    {
        if($name == 'UNKNOWN_ERROR') return $this->unknownError($result);
        $_SESSION['page_message'] = $name;
        return $result;
    }

    public function unknownError($page = false)
    {
        if($page) $_SESSION['page_message'] = 'UNKNOWN_ERROR';
        else $_SESSION['message'] = 'UNKNOWN_ERROR';
        return false;
    }
}