<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 10/20/17
 * Time: 5:16 PM
 */

namespace meow\base;

use Meow;

class AssetManager extends BaseApp
{
    public $assets = array();

    function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function addAsset($link, $where = 'head', $asset = 'script', $type = 'url'){
        //TODO доделать
        $hash = md5('addScript'.$link.$where.$asset.$type);
        $where = $where=='head' ? 'head' : 'body';
        $asset = $asset=='script' ? 'script' : 'style';
        if (!isset($this->assets[$hash])) {
            $this->assets[$hash] = array('where'=>$where,'asset'=>$asset,'type'=>$type,'data'=>$link);
        }
    }

}