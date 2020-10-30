<?php

namespace KrzysztofSobolewskiRekrutacjaHRtec\Entity;

use KrzysztofSobolewskiRekrutacjaHRtec\Exception\FieldDoesNotExistException;

/**
 * Class Item
 * @package KrzysztofSobolewskiRekrutacjaHRtec\Entity
 */
class Item
{
    /**
     * @param string $name
     * @return mixed
     * @throws FieldDoesNotExistException
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        } else {
            throw new FieldDoesNotExistException("field {$name} does not exist.");
        }
    }

    /**
     * @param string $name
     * @param $value
     * @throws FieldDoesNotExistException
     */
    public function __set(string $name, $value)
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
        } else {
            throw new FieldDoesNotExistException("field {$name} does not exist.");
        }
    }
}