<?php
namespace Bob\Phalcon\Definition;


interface Filter
{
    /**
     * @param string $key
     * @param string $val
     * @return mixed
     */
    public function filter($key, $val);
}