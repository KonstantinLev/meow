<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 18.12.2017
 * Time: 7:31
 */

namespace meow\base;


use Meow;

class ActiveModel extends Model
{
    private $tableSchema;
    private $primaryKey;

    public static function tableName()
    {
        return '';
    }

    public function __construct(array $config = [])
    {
        $this->tableSchema = self::getTableSchema();
        foreach ($this->tableSchema->columns as $key => $column){
            $this->createProperty($key);
            if ($column->isPrimaryKey){
                $this->primaryKey = $key;
            }
        }
        parent::__construct($config);
    }

    public static function getTableSchema()
    {
        $tableSchema = Meow::$app->getDb()
            ->getSchema()
            ->getTableSchema(static::tableName());

        if ($tableSchema === null) {
            throw new \Exception('The table does not exist: ' . static::tableName());
        }

        return $tableSchema;
    }
}