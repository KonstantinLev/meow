<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 6:39
 */

require_once 'config/config.php';
require_once 'email_class.php';


class Mail
{
    private $config;
    private $email;

    public function __construct()
    {
        $this->config = new Config();
        $this->email = new Email();
    }

    public function send($to, $data, $template, $from = '')
    {
        $data['sitename'] = $this->config->sitename;
        $subject = $this->email->getTitle($template);
        $message = $this->email->getText($template);
        $headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/html; charset=utf-8\r\n";
        foreach($data as $key => $val)
        {
            $subject = str_replace("%$key%", $val, $subject);
            $message = str_replace("%$key%", $val, $message);
        }
        $subject = '=?utf-8?B?'.base64_encode($subject).'?=';
        return mail($to, $subject, $message, $headers);
    }
}