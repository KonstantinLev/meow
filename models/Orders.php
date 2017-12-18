<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 10.12.2017
 * Time: 14:46
 */

namespace app\models;

use meow\base\ActiveModel;

/**
 * This is the model class for table "INQUIRY_FORMS".
 * Class Orders
 * @property $id
 * @property $product_ids
 * @property $price
 * @property $name
 * @property $phone
 * @property $email
 * @property $address
 * @property $notice
 * @property $is_delivery
 * @property $date_order
 * @package app\models
 */
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