<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 6:37
 */

require_once 'global_message_class.php';

class Message extends GlobalMessage
{
    public function __construct()
    {
        parent::__construct('messages');
    }
}