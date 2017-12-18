<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 18.12.2017
 * Time: 7:57
 */

namespace meow\db;


use meow\base\BaseApp;

class TableSchema extends BaseApp
{
    public $schemaName;
    public $name;
    public $fullName;
    public $primaryKey = [];
    public $foreignKeys = [];
    public $sequenceName;
    public $columns = [];

    public function __construct($name)
    {
        $this->name = $name;
        parent::__construct([]);
    }

    public function getColumn($name)
    {
        return isset($this->columns[$name]) ? $this->columns[$name] : null;
    }

    public function getName(){
        return $this->name;
    }
}