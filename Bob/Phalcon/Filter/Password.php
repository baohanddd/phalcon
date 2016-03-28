<?php
namespace Bob\Phalcon\Filter;

class Password
{
    public function filter($value)
    {
        if($value) return \Phalcon\DI::getDefault()->get('password')->generate($value);
        return $value;
    }
}