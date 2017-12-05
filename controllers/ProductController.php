<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 13.06.2017
 * Time: 2:28
 */

require_once 'BaseController.php';
require_once 'models/Product.php';

class ProductController extends BaseController
{
    protected function getContent()
    {
        $product_info = $this->product->get($this->getRequest('id'), $this->category->getTableName());
        if(!$product_info) return $this->notFound();
        $this->title = $product_info['title'];
        $this->meta_desc = 'Описание и покупка спиннера '.$product_info['title'];
        $this->meta_key = mb_strtolower('описание, спиннер '.$product_info['title'].', купить спиннер '.$product_info['title']);

        $this->template->set('linkCategory', $this->url->linkForCategories($product_info['fid_category']));
        $this->template->set('product', $product_info);
        $this->template->set('products', $this->product->getOthers($product_info));

        return 'product';
    }
}