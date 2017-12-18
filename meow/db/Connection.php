<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 19.10.2017
 * Time: 20:59
 */

namespace meow\db;

use Meow;
use meow\base\BaseApp;
use PDO;

class Connection extends BaseApp
{
    /**
     * @var PDO
     */
    public $pdo;
    public $dsn;
    public $username;
    public $password;
    public $charset;

    public $schemaMap = [
        'pgsql' => 'meow\db\pgsql\Schema', // PostgreSQL
        'mysqli' => 'meow\db\mysql\Schema', // MySQL
        'mysql' => 'meow\db\mysql\Schema', // MySQL
        'sqlite' => 'meow\db\sqlite\Schema', // sqlite 3
    ];

    /**
     * @var string driver name
     */
    public $_driverName;
    /**
     * @var Schema the database schema
     */
    private $_schema;

    public function __construct($config = [])
    {
        if (!isset($config['dsn']) || !isset($config['username']) || !isset($config['password'])) {
            throw new \Exception('Invalid DB configuration.');
        }
        parent::__construct($config);
        $this->init();
    }

    public function init(){
        $this->dsn = $this->_config['dsn'];
        $this->username = $this->_config['username'];
        $this->password = $this->_config['password'];
        $this->charset = $this->_config['charset'];
        $this->open();
    }

    public function open()
    {
        if ($this->pdo !== null) {
            return;
        }
        if (empty($this->dsn)) {
            throw new \Exception('Connection::dsn cannot be empty.');
        }
        try {
            $this->pdo = $this->createPdoInstance();
            $this->initConnection();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    public function close()
    {
        if ($this->pdo !== null) {
            $this->pdo = null;
        }
    }

    protected function createPdoInstance()
    {
        return new PDO($this->dsn, $this->username, $this->password);
    }

    protected function initConnection()
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($this->charset !== null && in_array($this->getDriverName(), ['pgsql', 'mysql', 'mysqli', 'cubrid'], true)) {
            $this->pdo->exec('SET NAMES ' . $this->pdo->quote($this->charset));
        }
    }

    public function getDriverName()
    {
        if ($this->_driverName === null) {
            if (($pos = strpos($this->dsn, ':')) !== false) {
                $this->_driverName = strtolower(substr($this->dsn, 0, $pos));
            } else {
                $this->_driverName = null;
            }
        }
        return $this->_driverName;
    }

    public function getSchema()
    {
        if ($this->_schema !== null) {
            return $this->_schema;
        }
        $driver = $this->getDriverName();
        if (isset($this->schemaMap[$driver])) {
            $className = $this->schemaMap[$driver];
            $config = ['db' => $this];
            return $this->_schema = new $className($config);
        }
        throw new \Exception("Connection does not support reading schema information for '$driver' DBMS.");
    }

    public function getTableSchema($name, $refresh = false)
    {
        return $this->getSchema()->getTableSchema($name, $refresh);
    }

    public function createCommand($sql, $params = []){
        return new Command($this, $sql, $params);
    }

    public function getPdo(){
        return $this->pdo;
    }
}