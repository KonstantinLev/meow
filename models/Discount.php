<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 13.06.2017
 * Time: 7:55
 */

require_once 'BaseModels.php';

class Discount extends BaseModels
{
    public function __construct()
    {
        parent::__construct('discounts');
    }

    public function getValueOnCode($code)
    {
        return $this->getField(['code' => $code], 'value_discount');
    }

}