<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 12/6/17
 * Time: 5:10 PM
 */

namespace app\controllers;

use meow\base\Controller;

class PostController extends Controller
{
    public function actionIndex()
    {
        //var_dump($foo);
        //var_dump(Meow::$app->getDb()->createCommand('select * from `orders`')->queryAll());
        return $this->render('index');
    }
}