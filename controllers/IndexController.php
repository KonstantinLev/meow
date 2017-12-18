<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 12/5/17
 * Time: 5:35 PM
 */

namespace app\controllers;

use meow\base\Controller;
use Meow;
use app\models\Orders;

class IndexController extends Controller
{
    /**
     * @return null|string
     * @throws \Exception
     */
    public function actionIndex()
    {
        var_dump(Meow::$app->getDb()->createCommand('select * from `orders`')->queryAll());
        $this->view->title = 'Привет';
        $orders = new Orders();
        $orders->load(['Orders' => ['name' => 'Константин', 'phone' => '666-66-66']]);
        $a = $orders->name;
        return $this->render('index');
    }

    /**
     * @return null|string
     * @throws \Exception
     */
    public function actionTest()
    {
        $a = 'ту-ту';
        $b = 'дудос';
        return $this->render('test', [
            'param1' => $a,
            'param2' => $b,
        ]);
    }
}