<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 12/5/17
 * Time: 5:35 PM
 */

namespace app\controllers;

use core\base\Controller;
use Meow;

class IndexController extends Controller
{
    public function actionIndex()
    {
        if (Meow::$app->request->isPost){

        }
        //var_dump($foo);
        //var_dump(Meow::$app->getDb()->createCommand('select * from `orders`')->queryAll());
        $this->render('index');
    }
}