<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 6:32
 */

require_once 'complex_message_class.php';

class Email extends ComplexMessage
{
    public function __construct()
    {
        parent::__construct('emails');
    }
}