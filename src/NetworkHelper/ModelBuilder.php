<?php


namespace App\NetworkHelper;


class ModelBuilder
{
    public function convert($class, array $arrayData)
    {
        $object = new $class();
        foreach ($arrayData as $key => $value)
        {
            $object->__set($key, $value);
        }

        return $object;
    }
}