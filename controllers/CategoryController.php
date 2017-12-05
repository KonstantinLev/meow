<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 12.06.2017
 * Time: 23:24
 */

require_once 'BaseController.php';
require_once 'models/Product.php';

class CategoryController extends BaseController
{
    protected function getContent()
    {
        $category_info = $this->category->get($this->getRequest('id'));
        if(!$category_info) return $this->notFound();
        $this->linkSort();
        $sort = $this->getRequest('sort');
        $up = $this->getRequest('up');

        $this->title = $category_info['title'];
        $this->meta_desc = 'Спиннеры из раздела '.$category_info['title'];
        $this->meta_key = mb_strtolower('список спиннеров, спиннеры, спиннеры из категории '.$category_info['title']);

        $this->template->set('categoryInfo', $category_info);
        $this->template->set('products', $this->product->getAllOnCategoryId(['fid_category' => $category_info['id'], 'is_available' => 1], $sort, $up));

        return 'category';
    }
}