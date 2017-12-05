<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 5:25
 */

require_once 'config/config.php';

class DB
{
    private static $db = null;
    private $config;
    private $mysqli;

    private function __construct()
    {
        $this->config = new Config();
        $this->mysqli = new mysqli($this->config->db_host, $this->config->db_user, $this->config->db_pass, $this->config->db_name);
        $this->mysqli->query("set name 'utf8'");
    }

    public static function getDB()
    {
        if (self::$db == null) self::$db = new DB();
        return self::$db;
    }

    /**
     * Замена в запросе параметров
     * @param $query
     * @param $params
     * @return mixed
     */
    private function getQuery($query, $params)
    {
        if ($params) {
            for ($i = 0; $i < count($params); $i++) {
                $pos = strpos($query, $this->config->sym_query);
                $arg = "'".$this->mysqli->real_escape_string($params[$i])."'";
                $query = substr_replace($query, $arg, $pos, strlen($this->config->sym_query));
            }
        }
        return $query;
    }

    /**
     * Запрос селект
     * @param $query
     * @param bool $params
     * @return array|bool
     */
    public function select($query, $params = false)
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if (!$result_set) return false;
        return $this->resultSetToArray($result_set);
    }

    /**
     * Получить строку
     * @param $query
     * @param bool $params
     * @return array|bool
     */
    public function selectRow($query, $params = false)
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if ($result_set->num_rows != 1) return false;
        return $result_set->fetch_assoc();
    }

    /**
     * Получить конкретную ячейку
     * @param $query
     * @param bool $params
     * @return bool
     */
    public function selectCell($query, $params = false)
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if ((!$result_set) || ($result_set->num_rows != 1)) return false;
        else {
            $arr = array_values($result_set->fetch_assoc());
            return $arr[0];
        }
    }


    public function execute($query, $params = false)
    {
        $result = $this->mysqli->query($this->getQuery($query, $params));
        if ($result) {
            if ($this->mysqli->insert_id === 0) return true;
            else return $this->mysqli->insert_id;
        } else {
            return false;
        }
    }

    /**
     * Преобразование данных в массив
     * @param $result_set
     * @return array
     */
    private function resultSetToArray($result_set)
    {
        $arr = array();
        while(($row = $result_set->fetch_assoc()) != false){
            $arr[] = $row;
        }
        return $arr;
    }

    public function __destruct()
    {
        if ($this->mysqli) $this->mysqli->close();
    }

}