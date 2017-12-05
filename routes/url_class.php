<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 5:50
 */

require_once 'config/config.php';
require_once 'libs/CoreUrl.php';

class Url extends CoreUrl
{

    public function index()
    {
        return $this->returnURL('');
    }

    public function cart()
    {
        return $this->returnURL('cart');
    }

    public function message()
    {
        return $this->returnURL('message');
    }

    public function actionForm()
    {
        return $this->returnURL('functions.php');
    }

    public function linkOrder()
    {
        return $this->returnURL('order');
    }

    //TODO просто для теста
    public function user($id)
    {
        return $this->returnURL("user?id_user=$id");
    }

    public function linkForCategories($id)
    {
        return $this->returnURL("category?id=$id");
    }

    public function linkForProduct($id)
    {
        return $this->returnURL("product?id=$id");
    }

    public function sortPriceUp()
    {
        return $this->sortOnField('price', 1);
    }

    public function sortPriceDown()
    {
        return $this->sortOnField('price', 0);
    }

    public function sortTitleUp()
    {
        return $this->sortOnField('title', 1);
    }

    public function sortTitleDown()
    {
        return $this->sortOnField('title', 0);
    }



    private function sortOnField($field, $up)
    {
        $currentUrl = $this->getThisURL();
        $currentUrl = $this->deleteGET($currentUrl, 'sort');
        $currentUrl = $this->deleteGET($currentUrl, 'up');
        if (strpos($currentUrl, '?') === false) $url = $currentUrl.'?sort='.$field.'&up='.$up;
        else $url = $currentUrl.'&sort='.$field.'&up='.$up;
        return $this->returnURL($url);
    }
}