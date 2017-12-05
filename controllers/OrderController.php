<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 13.06.2017
 * Time: 8:24
 */

require_once 'BaseController.php';
require_once 'models/Discount.php';

class OrderController extends BaseController
{
    protected $discount;

    public function __construct()
    {
        $this->discount = new Discount();
        parent::__construct();
    }

    protected function getContent()
    {
        $this->title = 'Оформление заказа';
        $this->meta_desc = 'Оформление заказа на покупку спиннера';
        $this->meta_key = 'заказ, оформление заказа, оформление заказа спиннер';

        $this->template->set('name', $_SESSION['name']);
        $this->template->set('phone', $_SESSION['phone']);
        $this->template->set('email', $_SESSION['email']);
        $this->template->set('address', $_SESSION['address']);
        $this->template->set('notice', $_SESSION['notice']);
        $this->template->set('message', $this->message());

        return 'order';
    }

}