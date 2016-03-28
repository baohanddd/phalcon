<?php
namespace Bob\Phalcon\Filter;

class Json
{
    public function filter($value)
    {
        return json_decode($value, true);
    }
}