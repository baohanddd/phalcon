<?php
namespace Bob\Phalcon\Filter;

class Token
{
    public function filter($value)
    {
        if(!$value) $value = \Phalcon\DI::getDefault()->get('token')->getId();
        return $value;
    }
}