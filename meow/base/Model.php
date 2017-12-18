<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 10.12.2017
 * Time: 17:18
 */

namespace meow\base;


use ReflectionClass;

class Model extends BaseApp
{
    //protected $_attributes;
    protected $_properties;

    public function __construct(array $config = [])
    {
        //TODO для теста
        //$this->properties();
        parent::__construct($config);
    }

    //TODO пока не используется
    public function properties()
    {
//        $class = new ReflectionClass($this);
//        $names = [];
//        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
//            if (!$property->isStatic()) {
//                $names[] = $property->getName();
//            }
//        }
//        return $names;
//        foreach ($this->_properties as $key => $val) {
//            $this->$key = $val;
//        }
        return $this->_properties;
    }

    /**
     * @return string
     */
    public function getModelName()
    {
        $rf = new ReflectionClass($this);
        return $rf->getShortName();
    }

    public function load($data)
    {
        $data = isset($data[$this->modelName]) ? $data[$this->modelName] : $data;
        if (!empty($data)) {
            $this->setProperties($data);
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [];
    }

    public function setProperties($values)
    {
        //TODO не проверять по атрибутам
        if (is_array($values)) {
            //$properties = array_flip($this->properties());
            foreach ($values as $name => $value) {
                if (array_key_exists($name, $this->_properties)) {
                    //$this->$name = $value;
                    $this->_properties[$name] = $value;
                }
            }
        }
    }

    public function hasProperty($name)
    {
        return isset($this->_properties[$name]) || in_array($name, $this->_properties, true);
    }

    public function createProperty($name, $value = null){
        if (!array_key_exists($name, $this->_properties)) $this->_properties[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($this->hasProperty($name)) {
            return $this->_properties[$name];
        }
        return parent::__get($name);
    }

    /**
     * @param $name
     * @param $value
     * @return null|void
     */
    public function __set($name, $value)
    {
        if ($this->hasProperty($name)) {
            $this->_properties[$name] = $value;
        }
        return null;
        //return $this;
    }
}