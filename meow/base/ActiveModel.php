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

    /**
     * ActiveModel constructor.
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->tableSchema = static::getTableSchema();
        foreach ($this->tableSchema->columns as $key => $column){
            $this->createProperty($key);
            //$this->$key = null;
            if ($column->isPrimaryKey){
                $this->primaryKey = $key;
            }
        }
    }

    /**
     * @return \meow\db\TableSchema
     * @throws \Exception
     */
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

    public function beforeSave()
    {

    }

    public function afterSave()
    {

    }

    public function save()
    {

    }
}