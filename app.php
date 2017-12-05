<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 13.06.17
 * Time: 11:57
 */

require_once 'routes/url_class.php';

class App
{
    public $dirControllers = 'controllers/';

    public function run()
    {
        $url = new Url();
        $view = $url->getView();
        $view = mb_convert_case($view, MB_CASE_TITLE, "UTF-8");
        $class = $view.'Controller';

        if(file_exists($this->dirControllers.$view.'Controller.php')){
            require_once $this->dirControllers.$view.'Controller.php';
            new $class;
        } else {
            require_once $this->dirControllers.'NotFoundController.php';
            new NotFoundController();
        }
    }
}