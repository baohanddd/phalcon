<?php
namespace Bob\Phalcon\Filter;

class Split
{
    public function filter($value)
    {
        return array_map('trim', explode(',', str_replace('，', ',', $value)));
    }
}