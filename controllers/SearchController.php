<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 19.06.2017
 * Time: 14:04
 */

require_once 'BaseController.php';

class SearchController extends BaseController
{
    protected function getContent()
    {
        $q = $this->getRequest('q');
        $this->title = 'Поиск: '.$q;
        $this->meta_desc = 'Поиск'.$q.'.';
        $this->meta_key = preg_replace("/\s+/i", ', ', mb_strtolower($q));

        //$this->template->set('name', $_SESSION['name']);
        $this->template->set('q', $q);
        $this->template->set('products', $this->product->search($q));
        return 'search';
    }
}