<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 18.12.2017
 * Time: 7:46
 */

namespace meow\db;


use meow\base\BaseApp;

class ColumnSchema extends BaseApp
{
    public $name;
    public $isPrimaryKey;
    public $allowNull;
    public $enumValues;
    public $autoIncrement;
    public $comment;
    public $phpType;
    public $dbType;
    public $type;
    public $size;
    public $precision;
    public $scale;
    public $unsigned;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
}