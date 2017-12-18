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
        parent::__construct($config);
    }

    public function properties()
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }

        return $names;
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
            $properties = array_flip($this->properties());
            foreach ($values as $name => $value) {
                if (isset($properties[$name])) {
                    $this->$name = $value;
                }
            }
        }
    }

    public function hasProperty($name)
    {
        return isset($this->_properties[$name]) || in_array($name, $this->properties(), true);
    }

    public function createProperty($name, $value = null){
        if (!array_key_exists($name, $this->_properties)) $this->_properties[$name] = $value;
    }

    public function __get($name)
    {
        if ($this->hasProperty($name)) {
            return $this->_properties[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if ($this->hasProperty($name)) {
            return $this->_properties[$name] = $value;
        }
        return null;
        //return $this;
    }
}