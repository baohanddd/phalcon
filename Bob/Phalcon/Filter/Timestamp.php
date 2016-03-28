<?php
namespace Bob\Phalcon\Filter;

class Timestamp
{
    public function filter($value)
    {
        $len = strlen((string) $value);
        if($len != 10)
            throw new \Bob\Phalcon\Exception\Filter\Timestamp();

        return $value;
    }
}