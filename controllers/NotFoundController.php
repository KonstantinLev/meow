<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 10.06.2017
 * Time: 14:31
 */

require_once 'BaseController.php';

class NotFoundController extends BaseController
{
    protected $title = 'Страница не найдена - 404';
    protected $meta_desc = 'Запрошенная страница не существует';
    protected $meta_key = 'Страница не найдена';

    protected function getContent()
    {
        header('HTTP/1.0 404 Not Found');
        return 'notfound';
    }

}