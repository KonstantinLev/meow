<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 20.10.2017
 * Time: 0:06
 */

namespace meow\db;


class Command
{
    /**
     * @var Connection
     */
    private $db;
    private $sql;
    private $params;

    /**
     * Command constructor.
     * @param $db
     * @param $sql
     * @param array $params
     */
    public function __construct($db, $sql, $params = [])
    {
        $this->db = $db;
        $this->sql = $sql;
        $this->params = $params;
    }

    /**
     * @return \PDOStatement
     * @throws \Exception
     */
    public function execute(){
        if ($this->db->getPdo() == null){
            throw new \Exception('Cannot execute command. No connection with DB');
        }
        $statement = $this->db->getPdo()->prepare($this->sql);
        foreach ($this->params as $key=>$value){
            if (substr($key, 0, 1) != ':'){
                $key = ':'.$key;
            }
            //TODO Пока только mysqli =)
            //$statement->bindValue($key, $value, $this->db->getSchema()->getPdoType($value));
            $statement->bindValue($key, $value, $this->getPdoType($value));
        }
        $statement->execute();
        return $statement;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function queryColumn(){
        $statement = $this->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function query(){
        $statement = $this->execute();
        return $statement->fetchAll();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function queryAssoc(){
        $statement = $this->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $data
     * @return int|mixed
     */
    public function getPdoType($data)
    {
        static $typeMap = [
            // php type => PDO type
            'boolean' => \PDO::PARAM_BOOL,
            'integer' => \PDO::PARAM_INT,
            'string' => \PDO::PARAM_STR,
            'resource' => \PDO::PARAM_LOB,
            'NULL' => \PDO::PARAM_NULL,
        ];
        $type = gettype($data);
        return isset($typeMap[$type]) ? $typeMap[$type] : \PDO::PARAM_STR;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function queryAll(){
        return $this->queryAssoc();
    }

}