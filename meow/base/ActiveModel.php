<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 18.12.2017
 * Time: 7:31
 */

namespace meow\base;


use Meow;

/**
 * @property bool isNewRecord
 * @property string primaryKey
 */
class ActiveModel extends Model
{
    private $tableSchema;
    private $primaryKey;
    //private $_properties;
    private $_oldProperties = null;

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

    /**
     * @return bool
     */
    public function getIsNewRecord()
    {
        return $this->_oldProperties === null;
    }

    public function beforeSave()
    {

    }

    public function afterSave()
    {

    }

    public function save()
    {
        //TODO обработать insert и update
        $this->beforeSave();
        if ($this->isNewRecord){
            $result = $this->insert();
        } else {
            $result = $this->update();
        }
        $this->afterSave();
        return $result;
    }
}