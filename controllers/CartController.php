<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 13.06.2017
 * Time: 5:44
 */

require_once 'BaseController.php';
require_once 'models/Discount.php';

class CartController extends BaseController
{
    protected $discount;

    public function __construct()
    {
        $this->discount = new Discount();
        parent::__construct();
    }

    protected function getContent()
    {
        $this->title = 'Корзина';
        $this->meta_desc = 'Содержимое корзины';
        $this->meta_key = mb_strtolower('корзина, содержимое корзины');

        $cart = [];
        $summ = 0;
        if($_SESSION['cart']){
            $ids = explode(',', $_SESSION['cart']);
            $products = $this->product->getAllOnIds($ids);
            $result = [];
            foreach($products as $product){
                $result[$product['id']] = $product;
            }
            $idsUnique = array_unique($ids);
            $i = 0;
            foreach ($idsUnique as $val){
                $cart[$i]['id'] = $result[$val]['id'];
                $cart[$i]['title'] = $result[$val]['title'];
                $cart[$i]['articul'] = $result[$val]['articul'];
                $cart[$i]['price'] = $result[$val]['price'];
                $cart[$i]['count'] = $this->getCountInArray($val, $ids);
                $cart[$i]['summ'] = $cart[$i]['count'] * $cart[$i]['price'];
                $cart[$i]['link_del'] = $result[$val]['link_del'];
                $summ += $cart[$i]['summ'];
                $i++;
            }
            $valDiscount = $this->discount->getValueOnCode($_SESSION['discount']);
            if($valDiscount){
                $summOld = $summ;
                $summ *= (1 - $valDiscount);
                $relDiscount = $summOld * $valDiscount;
                $absDiscount = ($valDiscount * 100).'%';
                $this->template->set('discount', $_SESSION['discount']);
                $this->template->set('relDiscount', $relDiscount);
                $this->template->set('absDiscount', $absDiscount);
            }

        }
        $this->template->set('summ', $summ);
        $this->template->set('cartItems', $cart);
        $this->template->set('link_order', $this->url->linkOrder());


        return 'cart';
    }

    private function getCountInArray($v, $ids)
    {
        $count = 0;
        foreach($ids as $val){
            if($val == $v) $count++;
        }
        return $count;
    }
}