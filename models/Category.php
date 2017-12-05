<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 10.06.2017
 * Time: 13:53
 */

require_once 'BaseModels.php';

class Category extends BaseModels
{
    public function __construct()
    {
        parent::__construct('categorys');
    }

    public function getAllCategories()
    {
        return $this->transform($this->getAll('id'));
    }

    protected function transformElement($data)
    {
        $data['link'] = $this->url->linkForCategories($data['id']);
        return $data;
    }
}