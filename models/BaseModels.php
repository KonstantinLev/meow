<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 10.06.2017
 * Time: 16:10
 */

require_once 'libs/CoreModels.php';
require_once 'routes/url_class.php';

class BaseModels extends CoreModels
{
    protected $url;

    public function __construct($table_name)
    {
        $this->url = new Url();
        parent::__construct($table_name);
    }
}