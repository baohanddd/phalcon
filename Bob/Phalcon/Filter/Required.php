<?php
namespace Bob\Phalcon\Filter;

class Required
{
    public function filter($value)
    {
        if($value === NULL)
            throw new \Bob\Phalcon\Exception\Required();
    }
}