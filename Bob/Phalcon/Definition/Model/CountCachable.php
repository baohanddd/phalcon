<?php
namespace Bob\Phalcon\Definition\Model;


interface CountCachable
{
    /**
     * @return array \Bob\Phalcon\Definition\Model\CountQueriable
     */
    public function countQueries();
}