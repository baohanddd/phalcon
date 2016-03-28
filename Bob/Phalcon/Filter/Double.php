<?php
namespace Bob\Phalcon\Filter;

class Double
{
    public function filter($value)
    {
        return (double) $value;
    }
}