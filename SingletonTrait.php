<?php

trait SingletonTrait
{

    public static function getInstance()
    {

        static $instances = [];

        $class = get_called_class();
        if(!isset($instances[$class]))
            $instances[$class] = new $class();

        return $instances[$class];

    }

}