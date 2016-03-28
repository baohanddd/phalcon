<?php
namespace Bob\Phalcon\Definition;


interface Rankable
{
    /**
     * @return int
     */
    public function score();
}