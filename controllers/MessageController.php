<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 19.06.2017
 * Time: 12:57
 */

require_once 'BaseController.php';
require_once 'libs/page_message_class.php';

class MessageController extends BaseController
{
    protected function getContent()
    {
        $pm = new PageMessage();
        $msgTitle = $pm->getTitle($_SESSION['page_message']);
        $msgText = $pm->getText($_SESSION['page_message']);
        $this->title = $msgTitle;
        $this->meta_desc = $msgText;
        $this->meta_key = preg_replace("/\s+/i", ', ', mb_strtolower($msgText));
        $this->template->set('msgTitle', $msgTitle);
        $this->template->set('msgText', $msgText);
        return 'message';
    }
}