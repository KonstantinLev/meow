<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 6:22
 */

require_once 'global_message_class.php';

abstract class ComplexMessage extends GlobalMessage
{
    public function getTitle($name)
    {
        return $this->get($name.'_TITLE');
    }

    public function getText($name)
    {
        return $this->get($name.'_TEXT');
    }
}