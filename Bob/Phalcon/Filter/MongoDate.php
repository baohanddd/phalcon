<?php
namespace Bob\Phalcon\Filter;

class MongoDate
{
    public function filter($value)
    {
        if(!$value) return new \MongoDate();
        return $value;
    }
}