<?php
namespace Bob\Phalcon\Filter;

class Like
{
    public function filter($value)
    {
        return ['$regex' => $value];
    }
}