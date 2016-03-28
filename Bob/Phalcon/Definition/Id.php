<?php
namespace Bob\Phalcon\Definition;


interface Id
{
    /**
     * @param bool|true $thrown
     * @return string
     */
    public function getId($thrown = true);
}