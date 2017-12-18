<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 10.12.2017
 * Time: 14:46
 */

namespace app\models;

use meow\base\ActiveModel;

class Orders extends ActiveModel
{
    public $test;
    public $foo;

    public static function tableName()
    {
        return 'orders';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id заказа',
            'product_ids' => 'id товаров, которые заказали',
            'price' => 'цена всего заказа',
            'name' => 'имя',
            'phone' => 'телефон',
            'email' => 'Email',
            'address' => 'Адрес доставки',
            'notice' => 'Примечания',
            'is_delivery' => 'Доставка/самовывоз',
            'date_order' => 'Дата звонка',
        ];
    }
}