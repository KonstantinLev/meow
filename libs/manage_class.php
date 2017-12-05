<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 13.06.2017
 * Time: 5:10
 */

require_once 'config/config.php';
require_once 'format_class.php';
require_once 'models/Product.php';
require_once 'models/Discount.php';
require_once 'models/Order.php';
require_once 'systemmessage_class.php';
require_once 'mail_class.php';

class Manage
{
    private $config;
    private $format;

    public function __construct()
    {
        session_start();
        $this->config = new Config();
        $this->format = new Format();
        $this->product = new Product();
        $this->discount = new Discount();
        $this->order = new Order();
        $this->sm = new SystemMessage();
        $this->request = $this->format->xss($_REQUEST);
        $this->saveData();
    }

    private function saveData()
    {
        foreach($this->request as $key => $val){
            $_SESSION[$key] = $val;
        }
    }

    public function addCart($id = false)
    {
        if (!$id) $id = $this->request['id'];
        if (!$this->product->existsID($id)) return false;
        if ($_SESSION['cart']){
            $_SESSION['cart'] .= ','.$id;
        } else {
            $_SESSION['cart'] = $id;
        }
    }

    public function deleteCart()
    {
        $id = $this->request['id'];
        $ids = explode(',', $_SESSION['cart']);
        $_SESSION['cart'] = '';
        foreach($ids as $val){
            if($val != $id) $this->addCart($val);
        }
    }

    public function updateCart()
    {
        //print_r($this->request);
        $_SESSION['cart'] = '';
        foreach ($this->request as $key => $val){
            if (strpos($key, 'count_') !== false){
                $id = substr($key, strlen('count_'));
                for($i = 0; $i < $val; $i++){
                    $this->addCart($id);
                }
            }
        }
        $_SESSION['discount'] = $this->request['discount'];
    }

    public function addOrder()
    {
        $tmpData = [];
        $tmpData['is_delivery'] = $this->request['is_delivery'];
        $tmpData['product_ids'] = $_SESSION['cart'];
        $tmpData['name'] = $this->request['name'];
        $tmpData['phone'] = $this->request['phone'];
        $tmpData['email'] = $this->request['email'];
        $tmpData['address'] = $this->request['address'];
        $tmpData['notice'] = $this->request['notice'];
        $tmpData['price'] = $this->getPrice();
        if($this->order->add($tmpData)){
            $mail = new Mail();
            $sendData = [];
            $sendData['order'] = $this->order->getOrderForMail($this->product);
            $sendData['name'] = $tmpData['name'];
            $sendData['phone'] = $tmpData['phone'];
            $sendData['email'] = $tmpData['email'];
            $sendData['address'] = $tmpData['address'];
            $sendData['notice'] = $tmpData['notice'];
            $sendData['price'] = $tmpData['price'];
            $to = $tmpData['email'];
            $mail->send($to, $sendData, 'ORDER');
            return $this->sm->pageMessage('ADD_ORDER');
        }
        return false;
    }

    private function getPrice()
    {
        $ids = explode(',', $_SESSION['cart']);
        $summ = $this->product->getPriceOnIds($ids);
        $discount = $this->discount->getValueOnCode($_SESSION['discount']);
        if($discount) $summ *= (1 - $discount);
        return $summ;
    }
}