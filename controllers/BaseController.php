<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 10.06.2017
 * Time: 15:47
 */

namespace app\controllers;

use core\base\Controller;


//require_once 'libs/CoreController.php';
//require_once 'routes/url_class.php';
//require_once 'models/Users.php';
//require_once 'models/Category.php';
//require_once 'models/Product.php';

class BaseController extends Controller
{
    public function actionIndex()
    {
        // TODO
    }
//    protected $user;
//    protected $category;
//    protected $url;
//    protected $product;
//    protected $template;
//
//    public function __construct()
//    {
////        parent::__construct();
////
////        $this->user = new Users();
////        $this->category = new Category();
////        $this->url = new Url();
////        $this->product = new Product();
////        $this->template = new Template($this->config->dir_views);
////
////        $this->setInfoCart();
////
////        $this->template->set('content', $this->getContent());
////        $this->template->set('config', $this->config);
////        $this->template->set('title', $this->title);
////        $this->template->set('meta_desc', $this->meta_desc);
////        $this->template->set('meta_key', $this->meta_key);
////        $this->template->set('index', $this->url->index());
////        $this->template->set('cart', $this->url->cart());
////        $this->template->set('action', $this->url->actionForm());
////
////        $this->template->set('categories', $this->category->getAllCategories());
////
////        $this->template->display('main');
////    }
////
////    protected function setInfoCart()
////    {
////        //unset($_SESSION['cart']);
////        $countIds = 0;
////        $summ = 0;
////        if($_SESSION['cart']){
////            $ids = explode(',', $_SESSION['cart']);
////            $countIds = count($ids);
////            $summ = $this->product->getPriceOnIds($ids);
////        }
////
////        $this->template->set('cart_count', $countIds);
////        $this->template->set('cart_sum', $summ);
////    }
////
////    protected function linkSort()
////    {
////        $this->template->set('linkPriceUp', $this->url->sortPriceUp());
////        $this->template->set('linkPriceDown', $this->url->sortPriceDown());
////        $this->template->set('linkTitleUp', $this->url->sortTitleUp());
////        $this->template->set('linkTitleDown', $this->url->sortTitleDown());
////    }
}